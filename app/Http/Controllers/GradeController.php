<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Grade Controller
 * 
 * This controller handles grade encoding and viewing with role-based access control.
 * Subject teachers can encode grades, while administrators and advisers have view-only access.
 * 
 * Features:
 * - Role-based access control (teachers encode, admin/adviser view-only)
 * - Grade encoding and retrieval
 * - Student grade management
 * 
 * @author Laravel LIS System
 * @version 2.0
 */

class GradeController extends Controller
{
    /**
     * Display student portal grades for the authenticated student
     */
    public function studentPortalGrades(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // For students, get the associated student record through the relationship
        $student = $user->student;
        
        if (!$student) {
            // Fallback: try to find student by LRN in username field
            $student = Student::where('lrn', $user->username)->first();
        }
        
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student record not found.']);
        }

        // Get grades for the current academic year
        $academicYear = '2025-2026'; // Updated to match the system default
        $quarter = $request->get('quarter', '1st Quarter'); // Default to 1st Quarter

        // Get grades for the student for the current academic year and quarter
        $grades = Grade::with(['subject'])
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->where('grading_period', $quarter)
            ->orderBy('subject_id')
            ->get();

        return view('portal.grades', compact('student', 'grades', 'academicYear', 'quarter'));
    }

    public function encode(Request $request, $classId = null)
    {
        // Only teachers can encode grades - administrators can only view
        if (!Auth::check() || Auth::user()->role !== 'teacher') {
            abort(403, 'Only subject teachers can encode grades. Administrators and advisers have view-only access.');
        }

        $students = Student::with(['schoolClass'])
            ->when($classId, function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $subjects = Subject::where('is_active', true)
            ->orderBy('name')
            ->get();

        $schoolClasses = SchoolClass::where('is_active', true)
            ->orderBy('grade_level')
            ->orderBy('section')
            ->get();

        $selectedClass = $classId ? SchoolClass::find($classId) : null;

        // Since this method is only accessible to teachers, set canEncode to true
        $canEncode = true;

        return view('grades.encode', compact('students', 'subjects', 'schoolClasses', 'selectedClass', 'canEncode'));
    }

    /**
     * View grades for administrators and advisers (read-only)
     */
    public function viewOnly(Request $request, $classId = null)
    {
        // Only administrators and advisers can access this view
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can access grade viewing.');
        }

        $students = Student::with(['schoolClass'])
            ->when($classId, function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $subjects = Subject::where('is_active', true)
            ->orderBy('name')
            ->get();

        $schoolClasses = SchoolClass::where('is_active', true)
            ->orderBy('grade_level')
            ->orderBy('section')
            ->get();

        $selectedClass = $classId ? SchoolClass::find($classId) : null;

        return view('grades.view-only', compact('students', 'subjects', 'schoolClasses', 'selectedClass'));
    }

    /**
     * Get grades for a specific student and academic year
     * Accessible by all authenticated users (teachers, admin, advisers, students)
     */
    public function getStudentGrades(Request $request, $studentId)
    {
        // Make academic_year optional with default value
        $academicYear = $request->get('academic_year', '2025-2026');

        // Validate student ID exists
        $student = Student::find($studentId);
        if (!$student) {
            Log::warning('Student not found', ['student_id' => $studentId]);
            return response()->json(['error' => 'Student not found'], 404);
        }

        try {
            // Get all grades for this student and academic year - no authentication restrictions
            // This allows admin/adviser to view grades immediately after teacher encoding
            $grades = Grade::with(['subject', 'teacher'])
                ->where('student_id', $studentId)
                ->where('academic_year', $academicYear)
                ->orderBy('subject_id')
                ->orderBy('grading_period')
                ->get();
            
            Log::info('Grades retrieved successfully', [
                'student_id' => $studentId,
                'academic_year' => $academicYear,
                'grade_count' => $grades->count(),
                'authenticated' => Auth::check(),
                'user_role' => Auth::check() ? Auth::user()->role : 'guest',
                'raw_grades' => $grades->toArray()
            ]);
            
            // Group grades by subject name and grading period for easier frontend processing
            $groupedGrades = $grades->groupBy(['subject.name', 'grading_period']);
            
            Log::info('Grouped grades structure', [
                'grouped_data' => $groupedGrades->toArray()
            ]);
            
            // Ensure response is always an object, even if empty
            $response = $groupedGrades->isEmpty() ? new \stdClass() : $groupedGrades;
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Error fetching student grades', [
                'student_id' => $studentId,
                'academic_year' => $academicYear,
                'authenticated' => Auth::check(),
                'user_role' => Auth::check() ? Auth::user()->role : 'guest',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Unable to fetch grades: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store or update grades
     */
    public function store(Request $request)
    {
        // Only teachers can encode grades - administrators cannot encode
        if (!Auth::check() || Auth::user()->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'Only subject teachers can encode grades. Administrators have view-only access.'
            ], 403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'academic_year' => 'required|string',
            'grades' => 'required|array',
            'grades.*.subject_id' => 'required|exists:subjects,id',
            'grades.*.grading_period' => 'required|string|in:1st Quarter,2nd Quarter,3rd Quarter,4th Quarter',
            'grades.*.score' => 'required|numeric|min:60|max:100'
        ]);

        DB::beginTransaction();

        try {
            $updatedGrades = [];
            
            foreach ($request->grades as $gradeData) {
                $score = (float) $gradeData['score'];
                $finalRating = $score; // For quarterly grades, score = final rating
                $remarks = $score >= 75 ? 'PASSED' : 'FAILED';

                $grade = Grade::updateOrCreate(
                    [
                        'student_id' => $request->student_id,
                        'subject_id' => $gradeData['subject_id'],
                        'grading_period' => $gradeData['grading_period'],
                        'academic_year' => $request->academic_year,
                    ],
                    [
                        'school_class_id' => $request->school_class_id,
                        'teacher_id' => Auth::id(),
                        'score' => $score,
                        'final_rating' => $finalRating,
                        'remarks' => $remarks,
                        'updated_at' => now(),
                    ]
                );
                
                // Ensure grade is saved to database immediately
                $grade->save();
                
                // Load relationships for response
                $grade->load(['student', 'subject', 'teacher']);
                $updatedGrades[] = $grade;
            }

            // Force commit to ensure data persistence across all sessions
            DB::commit();
            
            // Additional database flush to ensure immediate visibility for MySQL/MariaDB
            // Clear any query cache to ensure fresh reads for all user roles
            try {
                DB::statement('FLUSH TABLES');
            } catch (\Exception $e) {
                // If FLUSH TABLES fails (insufficient privileges), continue without error
                Log::warning('Could not flush tables - grades still saved successfully', ['error' => $e->getMessage()]);
            }
            
            Log::info('Grades saved successfully with forced persistence', [
                'teacher_id' => Auth::id(),
                'teacher_name' => Auth::user()->name,
                'student_id' => $request->student_id,
                'academic_year' => $request->academic_year,
                'grades_count' => count($updatedGrades),
                'saved_grades' => $updatedGrades->map(function($grade) {
                    return [
                        'id' => $grade->id,
                        'subject_name' => $grade->subject->name,
                        'grading_period' => $grade->grading_period,
                        'score' => $grade->score,
                        'created_at' => $grade->created_at,
                        'updated_at' => $grade->updated_at
                    ];
                })
            ]);
            
            // Grades saved successfully

            return response()->json([
                'success' => true,
                'message' => 'Grades saved and committed to database successfully!',
                'encoded_by' => Auth::user()->name,
                'updated_grades' => count($updatedGrades),
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the full error for debugging
            Log::error('Grade saving error', [
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'database_connection' => config('database.default'),
                'teacher_id' => Auth::id(),
                'student_id' => $request->student_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error saving grades: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate final grades for a student across all quarters
     */
    public function calculateFinalGrades(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year' => 'required|string'
        ]);

        $student = Student::find($request->student_id);
        $subjects = Subject::where('is_active', true)->get();

        $finalGrades = [];

        foreach ($subjects as $subject) {
            $quarterlyGrades = Grade::where('student_id', $student->id)
                ->where('subject_id', $subject->id)
                ->where('academic_year', $request->academic_year)
                ->pluck('score', 'grading_period')
                ->toArray();

            if (count($quarterlyGrades) >= 4) {
                $average = array_sum($quarterlyGrades) / count($quarterlyGrades);
                $remarks = $average >= 75 ? 'PASSED' : 'FAILED';

                $finalGrades[] = [
                    'subject' => $subject->name,
                    'quarters' => $quarterlyGrades,
                    'final_rating' => round($average, 2),
                    'remarks' => $remarks
                ];
            }
        }

        return response()->json([
            'student' => $student,
            'final_grades' => $finalGrades
        ]);
    }

    /**
     * View grades (for admin, adviser, and student access)
     */
    public function viewGrades(Request $request, $studentId = null)
    {
        $user = Auth::user();

        // Role-based access control for viewing grades
        if ($user->role === 'student') {
            // Students can only view their own grades
            $student = Student::where('id', $user->id)->first();
            if (!$student) {
                abort(404, 'Student record not found.');
            }
        } elseif (in_array($user->role, ['admin', 'adviser'])) {
            // Admin and advisers can view any student's grades
            $student = $studentId ? Student::find($studentId) : null;
        } else {
            abort(403, 'Access denied.');
        }

        if (!$student) {
            return view('grades.view', ['students' => Student::with('schoolClass')->get()]);
        }

        $academicYear = $request->get('academic_year', '2025-2026');

        $grades = Grade::with(['subject', 'teacher'])
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->orderBy('subject_id')
            ->orderBy('grading_period')
            ->get()
            ->groupBy('subject.name');

        return view('grades.view', compact('student', 'grades', 'academicYear'));
    }


}
