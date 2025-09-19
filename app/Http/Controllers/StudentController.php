<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Student Controller
 * 
 * This controller handles student enrollment and management for administrators and advisers.
 * Only admins and advisers can enroll, edit, and manage students.
 * 
 * Features:
 * - Role-based access control (admin and adviser only)
 * - Student CRUD operations
 * - Class enrollment management
 * - Student transfer between classes
 * 
 * @author Laravel LIS System
 * @version 1.0
 */
class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {
        // Only administrators and advisers can access student management
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can access student management.');
        }

        $query = Student::with(['schoolClass', 'schoolClass.adviser']);

        // Apply filters
        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('grade_level')) {
            $query->whereHas('schoolClass', function ($q) use ($request) {
                $q->where('grade_level', $request->grade_level);
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('status')) {
            $active = $request->status === 'active';
            $query->where('is_active', $active);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('lrn', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('last_name')
                         ->orderBy('first_name')
                         ->paginate(20);

        $classes = SchoolClass::where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();

        $gradeLevels = SchoolClass::distinct()->pluck('grade_level')->sort();

        return view('students.index', compact('students', 'classes', 'gradeLevels'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create(Request $request)
    {
        // Only administrators and advisers can create students
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can enroll students.');
        }
    
        $query = SchoolClass::where('is_active', true)
            ->orderBy('grade_level')
            ->orderBy('section');
    
        if (Auth::user()->role === 'adviser') {
          
            $query->where('adviser_id', Auth::id());
        }
    
        $classes = $query->get();
        $selectedClassId = $request->get('class_id');
    
        return view('students.create', compact('classes', 'selectedClassId'));
    }
    

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        // Only administrators and advisers can create students
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators and advisers can enroll students.'
            ], 403);
        }

        $request->validate([
            'lrn' => 'required|string|size:12|unique:students,lrn',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string|max:200',
            'contact_number' => 'nullable|string|max:15',
            'parent_guardian' => 'required|string|max:100',
            'parent_contact' => 'required|string|max:15',
            'school_class_id' => 'required|exists:school_classes,id',
            'student_type' => 'nullable|string|max:50',
            'mother_tongue' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'ethnic_group' => 'nullable|string|max:50'
        ]);

        // Check if the selected class has capacity
        $schoolClass = SchoolClass::find($request->school_class_id);
        $currentEnrollment = $schoolClass->students()->where('is_active', true)->count();

        if ($currentEnrollment >= $schoolClass->max_students) {
            return response()->json([
                'success' => false,
                'message' => "Class is full. Maximum capacity is {$schoolClass->max_students} students."
            ], 422);
        }

        DB::beginTransaction();

        try {
            $student = Student::create([
                'lrn' => $request->lrn,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'suffix' => $request->suffix,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'parent_guardian' => $request->parent_guardian,
                'parent_contact' => $request->parent_contact,
                'school_class_id' => $request->school_class_id,
                'student_type' => $request->student_type ?: 'Regular',
                'mother_tongue' => $request->mother_tongue,
                'religion' => $request->religion,
                'ethnic_group' => $request->ethnic_group,
                'is_active' => true
            ]);

            DB::commit();

            Log::info('Student enrolled successfully', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'lrn' => $student->lrn,
                'class_id' => $schoolClass->id,
                'class_name' => $schoolClass->class_name,
                'enrolled_by' => Auth::user()->name,
                'user_role' => Auth::user()->role
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Student enrolled successfully!',
                'student' => $student,
                'redirect' => route('students.show', $student->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error enrolling student', [
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error enrolling student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        // Only administrators and advisers can view student details
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can view student details.');
        }

        $student->load(['schoolClass', 'schoolClass.adviser', 'grades']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        // Only administrators and advisers can edit students
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can edit students.');
        }

        $classes = SchoolClass::where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();

        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, Student $student)
    {
        // Only administrators and advisers can update students
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators and advisers can update students.'
            ], 403);
        }

        $request->validate([
            'lrn' => 'required|string|size:12|unique:students,lrn,' . $student->id,
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string|max:200',
            'contact_number' => 'nullable|string|max:15',
            'parent_guardian' => 'required|string|max:100',
            'parent_contact' => 'required|string|max:15',
            'school_class_id' => 'required|exists:school_classes,id',
            'student_type' => 'nullable|string|max:50',
            'mother_tongue' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'ethnic_group' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        // Check if class change requires capacity validation
        if ($request->school_class_id != $student->school_class_id) {
            $newClass = SchoolClass::find($request->school_class_id);
            $currentEnrollment = $newClass->students()->where('is_active', true)->count();

            if ($currentEnrollment >= $newClass->max_students) {
                return response()->json([
                    'success' => false,
                    'message' => "Target class is full. Maximum capacity is {$newClass->max_students} students."
                ], 422);
            }
        }

        DB::beginTransaction();

        try {
            $oldClass = $student->schoolClass;

            $student->update([
                'lrn' => $request->lrn,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'suffix' => $request->suffix,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'parent_guardian' => $request->parent_guardian,
                'parent_contact' => $request->parent_contact,
                'school_class_id' => $request->school_class_id,
                'student_type' => $request->student_type ?: 'Regular',
                'mother_tongue' => $request->mother_tongue,
                'religion' => $request->religion,
                'ethnic_group' => $request->ethnic_group,
                'is_active' => $request->boolean('is_active', true)
            ]);

            DB::commit();

            $logData = [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'updated_by' => Auth::user()->name,
                'user_role' => Auth::user()->role
            ];

            if ($request->school_class_id != $oldClass->id) {
                $logData['class_transfer'] = [
                    'from' => $oldClass->class_name,
                    'to' => $student->schoolClass->class_name
                ];
            }

            Log::info('Student updated successfully', $logData);

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully!',
                'student' => $student
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating student', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student from storage
     */
    public function destroy(Student $student)
    {
        // Only administrators can delete students
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete students.'
            ], 403);
        }

        DB::beginTransaction();

        try {
            $studentName = $student->full_name;
            $studentLrn = $student->lrn;

            // Soft delete by setting is_active to false
            $student->update(['is_active' => false]);

            DB::commit();

            Log::info('Student deactivated successfully', [
                'student_name' => $studentName,
                'lrn' => $studentLrn,
                'deactivated_by' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Student deactivated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deactivating student', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deactivating student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get students as JSON for AJAX requests
     */
    public function getStudents(Request $request)
    {
        // Accessible by authenticated users
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Student::with('schoolClass');

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('active_only')) {
            $query->where('is_active', true);
        }

        $students = $query->orderBy('last_name')
                         ->orderBy('first_name')
                         ->get();

        return response()->json($students);
    }

    /**
     * Transfer student to another class
     */
    public function transfer(Request $request, Student $student)
    {
        // Only administrators and advisers can transfer students
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators and advisers can transfer students.'
            ], 403);
        }

        $request->validate([
            'new_class_id' => 'required|exists:school_classes,id|different:' . $student->school_class_id
        ]);

        $newClass = SchoolClass::find($request->new_class_id);
        $currentEnrollment = $newClass->students()->where('is_active', true)->count();

        if ($currentEnrollment >= $newClass->max_students) {
            return response()->json([
                'success' => false,
                'message' => "Target class is full. Maximum capacity is {$newClass->max_students} students."
            ], 422);
        }

        DB::beginTransaction();

        try {
            $oldClass = $student->schoolClass;
            $student->update(['school_class_id' => $request->new_class_id]);

            DB::commit();

            Log::info('Student transferred successfully', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'from_class' => $oldClass->class_name,
                'to_class' => $newClass->class_name,
                'transferred_by' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => "Student transferred from {$oldClass->class_name} to {$newClass->class_name}",
                'student' => $student->load('schoolClass')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error transferring student', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error transferring student: ' . $e->getMessage()
            ], 500);
        }
    }

    public function grades(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get the associated student record - try multiple methods
        $student = null;
        
        // Method 1: Direct relationship
        if ($user->student) {
            $student = $user->student;
        }
        
        // Method 2: Find by LRN = username
        if (!$student) {
            $student = Student::where('lrn', $user->username)->first();
        }
        
        // Method 3: Find by name matching
        if (!$student) {
            $student = Student::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$user->name])->first();
        }
        
        // Method 4: Find by username in student table
        if (!$student) {
            $student = Student::where('lrn', $user->username)->first();
        }
        
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student record not found.']);
        }
    
        // Get grades for the current academic year
        $academicYear = '2025-2026';
        $quarter = $request->get('quarter', '1st Quarter');
    
        // Get grades for the student for the current academic year and quarter
        $grades = Grade::with(['subject'])
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->where('grading_period', $quarter)
            ->orderBy('subject_id')
            ->get();
    
        // If this is an AJAX request, return JSON data
        if ($request->ajax() || $request->wantsJson()) {
            // Prepare the data for the response
            $gradesData = [];
            foreach ($grades as $grade) {
                $gradesData[] = [
                    'subject' => $grade->subject->name ?? 'N/A',
                    'final_rating' => $grade->final_rating,
                    'remarks' => $grade->remarks,
                    'passed' => $grade->final_rating >= 75
                ];
            }
            
            // Calculate summary data
            $summary = [
                'general_average' => $grades->count() > 0 ? $grades->avg('final_rating') : 0,
                'highest_grade' => $grades->count() > 0 ? $grades->max('final_rating') : 0,
                'subjects_passed' => $grades->where('final_rating', '>=', 75)->count(),
                'total_subjects' => $grades->count(),
                'pass_rate' => $grades->count() > 0 ? ($grades->where('final_rating', '>=', 75)->count() / $grades->count()) * 100 : 0
            ];
            
            // Get highest grade subject name
            if ($grades->count() > 0) {
                $highestGradeSubject = $grades->where('final_rating', $grades->max('final_rating'))->first();
                $summary['highest_grade_subject'] = $highestGradeSubject->subject->name ?? 'N/A';
            } else {
                $summary['highest_grade_subject'] = 'N/A';
            }
            
            return response()->json([
                'grades' => $gradesData,
                'summary' => $summary,
                'quarter' => $quarter
            ]);
        }
    
        return view('portal.grades', compact('student', 'grades', 'academicYear', 'quarter'));
    }
}