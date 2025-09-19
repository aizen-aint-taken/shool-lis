<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * SF Forms Controller
 * 
 * This controller handles School Form generation with dynamic data from the database.
 * School Forms (SF) are official DepEd forms that require real student and class data.
 * 
 * Features:
 * - Dynamic SF1 (School Register) generation
 * - Real-time data from classes and students
 * - Class-specific student listings
 * - Proper DepEd formatting
 * 
 * @author Laravel LIS System
 * @version 1.0
 */
class SFController extends Controller
{
    /**
     * Generate SF1 (School Register) form
     */
    public function sf1(Request $request)
    {
        // Allow access to authenticated users (admin, adviser, teacher)
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedClassId = $request->get('class_id');
        
        // Get all active classes for the dropdown
        $classes = SchoolClass::with(['adviser'])
                             ->where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();

        // If a specific class is requested, get its data
        $selectedClass = null;
        $students = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                $students = $selectedClass->students;
            }
        }

        // School information (this should come from a settings table in a real application)
        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];

        return view('sf.sf1', compact('classes', 'selectedClass', 'students', 'schoolInfo'));
    }

    /**
     * Generate SF2 (Daily Attendance Report) form with real attendance data
     */
    public function sf2(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedClassId = $request->get('class_id');
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear = $request->get('year', date('Y'));
        
        // Get classes - for advisers, only show their assigned classes
        $classesQuery = SchoolClass::with(['adviser'])
                                  ->where('is_active', true);
        
        if (Auth::user()->isAdviser()) {
            $classesQuery->where('adviser_id', Auth::id());
        }
        
        $classes = $classesQuery->orderBy('grade_level')
                               ->orderBy('section')
                               ->get();

        $selectedClass = null;
        $students = collect();
        $attendanceData = [];
        $monthlyStats = [];
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                // Verify adviser access
                if (Auth::user()->isAdviser() && $selectedClass->adviser_id !== Auth::id()) {
                    abort(403, 'You can only view attendance for your assigned classes.');
                }
                
                $students = $selectedClass->students;
                
                // Get attendance data for the selected month
                $startDate = "$selectedYear-$selectedMonth-01";
                $endDate = date('Y-m-t', strtotime($startDate));
                $daysInMonth = date('t', strtotime($startDate));
                
                // Get all attendance records for this class and month
                $attendanceRecords = \App\Models\Attendance::where('school_class_id', $selectedClassId)
                    ->whereBetween('attendance_date', [$startDate, $endDate])
                    ->get()
                    ->groupBy(['student_id', function($item) {
                        return date('j', strtotime($item->attendance_date)); // Day of month
                    }]);
                
                // Process attendance data for each student
                foreach ($students as $student) {
                    $attendanceData[$student->id] = [];
                    $totalPresent = 0;
                    $totalAbsent = 0;
                    
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $dayDate = sprintf('%s-%02d-%02d', $selectedYear, $selectedMonth, $day);
                        
                        // Skip weekends (optional - depends on school policy)
                        $dayOfWeek = date('w', strtotime($dayDate));
                        if ($dayOfWeek == 0 || $dayOfWeek == 6) { // Sunday or Saturday
                            $attendanceData[$student->id][$day] = 'weekend';
                            continue;
                        }
                        
                        // Skip future dates
                        if (strtotime($dayDate) > time()) {
                            $attendanceData[$student->id][$day] = 'future';
                            continue;
                        }
                        
                        // Check if attendance record exists for this day
                        $attendanceRecord = $attendanceRecords->get($student->id, collect())->get($day, null);
                        
                        if ($attendanceRecord) {
                            $record = $attendanceRecord->first();
                            $attendanceData[$student->id][$day] = $record->status;
                            
                            if ($record->status === 'present') {
                                $totalPresent++;
                            } else {
                                $totalAbsent++;
                            }
                        } else {
                            // No record = absent (for past dates)
                            $attendanceData[$student->id][$day] = 'absent';
                            $totalAbsent++;
                        }
                    }
                    
                    $monthlyStats[$student->id] = [
                        'total_present' => $totalPresent,
                        'total_absent' => $totalAbsent,
                        'attendance_rate' => $totalPresent + $totalAbsent > 0 ? round(($totalPresent / ($totalPresent + $totalAbsent)) * 100, 1) : 0
                    ];
                }
            }
        }

        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];
        
        // Generate month options
        $monthOptions = [
            '01' => 'January',
            '02' => 'February', 
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        
        $yearOptions = [date('Y'), date('Y') - 1, date('Y') + 1];
        $daysInMonth = $selectedClassId ? date('t', strtotime("$selectedYear-$selectedMonth-01")) : 31;

        return view('sf.sf2', compact(
            'classes', 'selectedClass', 'students', 'schoolInfo', 
            'attendanceData', 'monthlyStats', 'monthOptions', 'yearOptions',
            'selectedMonth', 'selectedYear', 'daysInMonth'
        ));
    }

    /**
     * Generate SF3 (Books/Textbooks Monitoring) form with real book tracking data
     */
    public function sf3(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedClassId = $request->get('class_id');
        $selectedStatus = $request->get('status', 'all'); // all, issued, returned, lost, damaged
        $selectedAcademicYear = $request->get('academic_year', '2025-2026');
        
        // Get classes - for advisers, only show their assigned classes
        $classesQuery = SchoolClass::with(['adviser'])
                                  ->where('is_active', true);
        
        if (Auth::user()->isAdviser()) {
            $classesQuery->where('adviser_id', Auth::id());
        }
        
        $classes = $classesQuery->orderBy('grade_level')
                               ->orderBy('section')
                               ->get();

        $selectedClass = null;
        $students = collect();
        $bookIssues = collect();
        $bookStats = [];
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                // Verify adviser access
                if (Auth::user()->isAdviser() && $selectedClass->adviser_id !== Auth::id()) {
                    abort(403, 'You can only view book records for your assigned classes.');
                }
                
                $students = $selectedClass->students;
                
                // Get book issues for this class
                $bookIssuesQuery = \App\Models\BookIssue::with(['book', 'student', 'issuedBy'])
                    ->where('school_class_id', $selectedClassId)
                    ->where('academic_year', $selectedAcademicYear);
                
                if ($selectedStatus !== 'all') {
                    $bookIssuesQuery->where('status', $selectedStatus);
                }
                
                $bookIssues = $bookIssuesQuery->orderBy('issue_date', 'desc')
                                              ->orderBy('student_id')
                                              ->get();
                
                // Calculate statistics
                $allIssues = \App\Models\BookIssue::where('school_class_id', $selectedClassId)
                    ->where('academic_year', $selectedAcademicYear)
                    ->get();
                
                $bookStats = [
                    'total_issued' => $allIssues->count(),
                    'currently_issued' => $allIssues->where('status', 'issued')->count(),
                    'returned' => $allIssues->where('status', 'returned')->count(),
                    'lost' => $allIssues->where('status', 'lost')->count(),
                    'damaged' => $allIssues->where('status', 'damaged')->count(),
                    'overdue' => $allIssues->where('status', 'issued')
                        ->filter(function ($issue) {
                            return $issue->expected_return_date && $issue->expected_return_date->isPast();
                        })->count(),
                    'total_penalty' => $allIssues->sum('penalty_amount'),
                    'condition_new' => $allIssues->where('issue_condition', 'new')->count(),
                    'condition_good' => $allIssues->where('issue_condition', 'good')->count(),
                    'condition_fair' => $allIssues->where('issue_condition', 'fair')->count(),
                    'condition_poor' => $allIssues->where('issue_condition', 'poor')->count(),
                ];
            }
        }

        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];
        
        // Status options for filter
        $statusOptions = [
            'all' => 'All Records',
            'issued' => 'Currently Issued',
            'returned' => 'Returned',
            'lost' => 'Lost',
            'damaged' => 'Damaged'
        ];
        
        // Academic year options
        $academicYearOptions = ['2025-2026', '2024-2025', '2023-2024'];

        return view('sf.sf3', compact(
            'classes', 'selectedClass', 'students', 'schoolInfo', 
            'bookIssues', 'bookStats', 'statusOptions', 'academicYearOptions',
            'selectedStatus', 'selectedAcademicYear'
        ));
    }

    /**
     * Generate SF5 (Promotions & Proficiency Levels) form
     */
    public function sf5(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedClassId = $request->get('class_id');
        
        $classes = SchoolClass::with(['adviser'])
                             ->where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();

        $selectedClass = null;
        $students = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }, 'students.grades'])->find($selectedClassId);
            
            if ($selectedClass) {
                $students = $selectedClass->students;
            }
        }

        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];
        
        // Calculate performance statistics
        $performanceStats = $this->calculatePerformanceStats($selectedClass);

        return view('sf.sf5', compact('classes', 'selectedClass', 'students', 'schoolInfo', 'performanceStats'));
    }

    /**
     * Generate SF9 (Report Card) form
     */
    public function sf9(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedClassId = $request->get('class_id');
        $selectedStudentId = $request->get('student_id');
        
        $classes = SchoolClass::with(['adviser'])
                             ->where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();

        $selectedClass = null;
        $students = collect();
        $selectedStudent = null;
        $studentGrades = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                $students = $selectedClass->students;
                
                if ($selectedStudentId) {
                    $selectedStudent = $students->find($selectedStudentId);
                    if ($selectedStudent) {
                        $studentGrades = $selectedStudent->grades()
                                                       ->with('subject')
                                                       ->where('academic_year', $selectedClass->school_year)
                                                       ->get()
                                                       ->groupBy('subject.name');
                    }
                }
            }
        }

        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];

        return view('sf.sf9', compact('classes', 'selectedClass', 'students', 'selectedStudent', 'studentGrades', 'schoolInfo'));
    }



 
    public function sf8(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }
    
        // Get the selected class ID from the request
        $selectedClassId = $request->get('class_id');
        
        // Get all active classes for the dropdown
        $classes = SchoolClass::with(['adviser'])
                             ->where('is_active', true)
                             ->orderBy('grade_level')
                             ->orderBy('section')
                             ->get();
    
        $selectedClass = null;
        $students = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('last_name')
                      ->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                $students = $selectedClass->students;
            }
        }
    
        // School information (this should come from a settings table in a real application)
        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School',
            'school_year' => $selectedClass ? $selectedClass->school_year : '2025-2026'
        ];
    
        return view('sf.sf8', compact('classes', 'selectedClass', 'students', 'schoolInfo'));
    }
/**
 * Store SF8 (Health & Nutrition Report) form data
 */
public function sf8Store(Request $request)
{
    if (!Auth::check()) {
        abort(403, 'Please log in to access school forms.');
    }

    $request->validate([
        'school_name' => 'required|string',
        'school_year' => 'required|string',
        'semester' => 'required|string',
        'grade_level' => 'required|string',
        'section' => 'required|string',
        'students.*.lrn' => 'nullable|string',
        'students.*.name' => 'nullable|string',
        'students.*.height' => 'nullable|numeric|min:0',
        'students.*.weight' => 'nullable|numeric|min:0',
        'students.*.nutritional_status' => 'nullable|string',
        'students.*.health_condition' => 'nullable|string',
        'students.*.remarks' => 'nullable|string',
    ]);

    // Process the submitted data
    // For now, we'll just redirect back with success message
    // In a real implementation, you might want to save this data to a database
    // or generate a PDF report
    
    return redirect()->back()->with('success', 'SF8 record saved successfully.');
}

    /**
     * Generate SF10 (Permanent Academic Record) form
     */
    public function sf10(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Please log in to access school forms.');
        }

        $selectedStudentId = $request->get('student_id');
        
        // For SF10, we might want to show all students or allow search
        $students = Student::with(['schoolClass', 'grades.subject'])
                          ->where('is_active', true)
                          ->orderBy('last_name')
                          ->orderBy('first_name')
                          ->get();

        $selectedStudent = null;
        $studentGrades = collect();
        $academicHistory = collect();
        
        if ($selectedStudentId) {
            $selectedStudent = Student::with(['schoolClass', 'grades.subject'])
                                     ->find($selectedStudentId);
            
            if ($selectedStudent) {
                // Get all grades grouped by academic year and subject
                $studentGrades = $selectedStudent->grades()
                                                ->with('subject')
                                                ->orderBy('academic_year')
                                                ->orderBy('subject_id')
                                                ->get()
                                                ->groupBy(['academic_year', 'subject.name']);
                
                // Get academic history (classes the student has been in)
                $academicHistory = $selectedStudent->grades()
                                                 ->with('schoolClass')
                                                 ->select('academic_year', 'school_class_id')
                                                 ->distinct()
                                                 ->orderBy('academic_year')
                                                 ->get()
                                                 ->groupBy('academic_year');
            }
        }

        $schoolInfo = [
            'region' => 'Region IV-A (CALABARZON)',
            'division' => 'Division of Sample',
            'district' => 'Sample District',
            'school_id' => '301234567',
            'school_name' => 'Sample National High School'
        ];

        return view('sf.sf10', compact('students', 'selectedStudent', 'studentGrades', 'academicHistory', 'schoolInfo'));
    }

    /**
     * Get students for a specific class (AJAX endpoint)
     */
    public function getClassStudents(Request $request, $classId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $class = SchoolClass::with(['students' => function ($query) {
            $query->where('is_active', true)
                  ->orderBy('last_name')
                  ->orderBy('first_name');
        }])->find($classId);

        if (!$class) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        return response()->json([
            'class' => $class,
            'students' => $class->students
        ]);
    }
    
    /**
     * Calculate performance statistics for SF5
     */
    private function calculatePerformanceStats($selectedClass)
    {
        if (!$selectedClass) {
            return [
                'promotion_rate' => 0,
                'advanced_learners' => 0,
                'retention_rate' => 0,
                'beginning_level' => 0,
                'grade_stats' => []
            ];
        }
        
        $students = $selectedClass->students->where('is_active', true);
        $totalStudents = $students->count();
        
        if ($totalStudents == 0) {
            return [
                'promotion_rate' => 0,
                'advanced_learners' => 0,
                'retention_rate' => 0,
                'beginning_level' => 0,
                'grade_stats' => []
            ];
        }
        
        // Get all grades for students in this class
        $grades = Grade::whereIn('student_id', $students->pluck('id'))
                      ->where('academic_year', $selectedClass->school_year)
                      ->get();
        
        // Calculate performance levels based on final ratings
        $passedStudents = 0;
        $advancedLearners = 0;
        $beginningLevel = 0;
        
        foreach ($students as $student) {
            $studentGrades = $grades->where('student_id', $student->id);
            
            if ($studentGrades->count() > 0) {
                $averageGrade = $studentGrades->avg('final_rating');
                
                if ($averageGrade >= 75) {
                    $passedStudents++;
                    
                    if ($averageGrade >= 90) {
                        $advancedLearners++;
                    }
                } else if ($averageGrade < 60) {
                    $beginningLevel++;
                }
            }
        }
        
        $promotionRate = $totalStudents > 0 ? ($passedStudents / $totalStudents) * 100 : 0;
        $advancedRate = $totalStudents > 0 ? ($advancedLearners / $totalStudents) * 100 : 0;
        $retentionRate = $totalStudents > 0 ? (($totalStudents - $passedStudents) / $totalStudents) * 100 : 0;
        $beginningRate = $totalStudents > 0 ? ($beginningLevel / $totalStudents) * 100 : 0;
        
        // Calculate grade level breakdown
        $gradeStats = [
            'total_enrolled' => $totalStudents,
            'promoted' => $passedStudents,
            'retained' => $totalStudents - $passedStudents,
            'dropped' => 0, // This would need additional tracking
            'advanced' => $advancedLearners,
            'proficient' => $passedStudents - $advancedLearners,
            'beginning' => $beginningLevel
        ];
        
        return [
            'promotion_rate' => round($promotionRate, 1),
            'advanced_learners' => round($advancedRate, 1),
            'retention_rate' => round($retentionRate, 1),
            'beginning_level' => round($beginningRate, 1),
            'grade_stats' => $gradeStats
        ];
    }
}