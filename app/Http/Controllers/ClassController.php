<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class Controller
 * 
 * This controller handles class management for administrators and advisers.
 * Only admins and advisers can create, edit, and manage classes.
 * 
 * Features:
 * - Role-based access control (admin and adviser only)
 * - Class CRUD operations
 * - Student enrollment management
 * - Class listing and filtering
 * 
 * @author Laravel LIS System
 * @version 1.0
 */
class ClassController extends Controller
{
    /**
     * Display a listing of classes
     */
    public function index(Request $request)
    {
        // Only administrators and advisers can access class management
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can access class management.');
        }

        $query = SchoolClass::with(['adviser', 'students']);

        // Apply filters
        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('school_year')) {
            $query->where('school_year', $request->school_year);
        }

        if ($request->filled('status')) {
            $active = $request->status === 'active';
            $query->where('is_active', $active);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('class_name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%")
                  ->orWhereHas('adviser', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Order by grade level and section
        $classes = $query->orderBy('grade_level')
                        ->orderBy('section')
                        ->paginate(15);

        $gradeLevels = SchoolClass::distinct()->pluck('grade_level')->sort();
        $schoolYears = SchoolClass::distinct()->pluck('school_year')->sort()->reverse();
        $advisers = User::where('role', 'adviser')->get();

        return view('classes.index', compact('classes', 'gradeLevels', 'schoolYears', 'advisers'));
    }

    /**
     * Show the form for creating a new class
     */
    public function create()
    {
        // Only administrators and advisers can create classes
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can create classes.');
        }

        $advisers = User::where('role', 'adviser')->get();
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $defaultSchoolYear = $currentYear . '-' . $nextYear;

        return view('classes.create', compact('advisers', 'defaultSchoolYear'));
    }

    /**
     * Store a newly created class
     */
    public function store(Request $request)
    {
        // Only administrators and advisers can create classes
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators and advisers can create classes.'
            ], 403);
        }

        $request->validate([
            'grade_level' => 'required|integer|min:7|max:12',
            'section' => 'required|string|max:50',
            'school_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'adviser_id' => 'nullable|exists:users,id',
            'max_students' => 'required|integer|min:10|max:50',
            'class_name' => 'nullable|string|max:100'
        ]);

        // Check for duplicate class (same grade level, section, and school year)
        $existingClass = SchoolClass::where('grade_level', $request->grade_level)
                                   ->where('section', $request->section)
                                   ->where('school_year', $request->school_year)
                                   ->first();

        if ($existingClass) {
            return response()->json([
                'success' => false,
                'message' => 'A class with the same grade level, section, and school year already exists.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Generate class name if not provided
            $className = $request->class_name ?: "Grade {$request->grade_level} - {$request->section}";

            $class = SchoolClass::create([
                'class_name' => $className,
                'grade_level' => $request->grade_level,
                'section' => $request->section,
                'school_year' => $request->school_year,
                'adviser_id' => $request->adviser_id,
                'max_students' => $request->max_students,
                'is_active' => true
            ]);

            DB::commit();

            Log::info('Class created successfully', [
                'class_id' => $class->id,
                'class_name' => $class->class_name,
                'created_by' => Auth::user()->name,
                'user_role' => Auth::user()->role
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Class created successfully!',
                'class' => $class,
                'redirect' => route('classes.show', $class->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating class', [
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating class: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified class
     */
    public function show(SchoolClass $class)
    {
        // Only administrators and advisers can view classes
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can view classes.');
        }

        $class->load(['adviser', 'students' => function ($query) {
            $query->orderBy('last_name')->orderBy('first_name');
        }]);

        $enrollmentStats = [
            'total_enrolled' => $class->students->where('is_active', true)->count(),
            'male_count' => $class->students->where('is_active', true)->where('gender', 'Male')->count(),
            'female_count' => $class->students->where('is_active', true)->where('gender', 'Female')->count(),
            'capacity' => $class->max_students,
            'available_slots' => $class->max_students - $class->students->where('is_active', true)->count()
        ];

        return view('classes.show', compact('class', 'enrollmentStats'));
    }

    /**
     * Show the form for editing the specified class
     */
    public function edit(SchoolClass $class)
    {
        // Only administrators and advisers can edit classes
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            abort(403, 'Only administrators and advisers can edit classes.');
        }

        $advisers = User::where('role', 'adviser')->get();

        return view('classes.edit', compact('class', 'advisers'));
    }

    /**
     * Update the specified class
     */
    public function update(Request $request, SchoolClass $class)
    {
        // Only administrators and advisers can update classes
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'adviser'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators and advisers can update classes.'
            ], 403);
        }

        $request->validate([
            'grade_level' => 'required|integer|min:7|max:12',
            'section' => 'required|string|max:50',
            'school_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'adviser_id' => 'nullable|exists:users,id',
            'max_students' => 'required|integer|min:10|max:50',
            'class_name' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);

        // Check for duplicate class (excluding current class)
        $existingClass = SchoolClass::where('grade_level', $request->grade_level)
                                   ->where('section', $request->section)
                                   ->where('school_year', $request->school_year)
                                   ->where('id', '!=', $class->id)
                                   ->first();

        if ($existingClass) {
            return response()->json([
                'success' => false,
                'message' => 'Another class with the same grade level, section, and school year already exists.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Generate class name if not provided
            $className = $request->class_name ?: "Grade {$request->grade_level} - {$request->section}";

            $class->update([
                'class_name' => $className,
                'grade_level' => $request->grade_level,
                'section' => $request->section,
                'school_year' => $request->school_year,
                'adviser_id' => $request->adviser_id,
                'max_students' => $request->max_students,
                'is_active' => $request->boolean('is_active', true)
            ]);

            DB::commit();

            Log::info('Class updated successfully', [
                'class_id' => $class->id,
                'class_name' => $class->class_name,
                'updated_by' => Auth::user()->name,
                'user_role' => Auth::user()->role
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Class updated successfully!',
                'class' => $class
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating class', [
                'class_id' => $class->id,
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating class: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified class from storage
     */
    public function destroy(SchoolClass $class)
    {
        // Only administrators can delete classes
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete classes.'
            ], 403);
        }

        // Check if class has enrolled students
        $enrolledStudents = $class->students()->where('is_active', true)->count();
        if ($enrolledStudents > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete class with {$enrolledStudents} enrolled students. Please transfer students first."
            ], 422);
        }

        DB::beginTransaction();

        try {
            $className = $class->class_name;
            $class->delete();

            DB::commit();

            Log::info('Class deleted successfully', [
                'class_name' => $className,
                'deleted_by' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Class deleted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting class', [
                'class_id' => $class->id,
                'error' => $e->getMessage(),
                'user' => Auth::user()->name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting class: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get classes as JSON for AJAX requests
     */
    public function getClasses(Request $request)
    {
        // Accessible by authenticated users
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = SchoolClass::with('adviser');

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('active_only')) {
            $query->where('is_active', true);
        }

        $classes = $query->orderBy('grade_level')
                        ->orderBy('section')
                        ->get();

        return response()->json($classes);
    }
}