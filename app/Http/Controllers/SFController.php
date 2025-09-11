<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
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
     * Generate SF2 (Enrollment and Attendance) form
     */
    public function sf2(Request $request)
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
            }])->find($selectedClassId);
            
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

        return view('sf.sf2', compact('classes', 'selectedClass', 'students', 'schoolInfo'));
    }

    /**
     * Generate SF3 (Books/Textbooks Monitoring) form
     */
    public function sf3(Request $request)
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
            }])->find($selectedClassId);
            
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

        return view('sf.sf3', compact('classes', 'selectedClass', 'students', 'schoolInfo'));
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

        return view('sf.sf5', compact('classes', 'selectedClass', 'students', 'schoolInfo'));
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
}