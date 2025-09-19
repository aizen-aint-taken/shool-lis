<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SFController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;

// ============================================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================================

Route::view('/', 'portal.login');
Route::get('/login', function () {
    return view('portal.login');
})->name('login');
Route::view('/portal/login', 'portal.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Public API route for student grade viewing (controller handles auth)
Route::get('/grades/student/{studentId}', [GradeController::class, 'getStudentGrades'])->name('grades.student');

// ============================================================================
// ADMIN ONLY ROUTES
// ============================================================================

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard and Core Functions
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/advisers/create', [AdminController::class, 'createAdviser'])->name('admin.advisers.create');
    Route::post('/admin/advisers', [AdminController::class, 'storeAdviser'])->name('admin.advisers.store');
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/users/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');
    
    // Admin Class Management (prefixed routes)
    Route::get('/admin/classes', [ClassController::class, 'index'])->name('admin.classes.index');
    Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('admin.classes.create');
    Route::post('/admin/classes', [ClassController::class, 'store'])->name('admin.classes.store');
    Route::get('/admin/classes/{class}', [ClassController::class, 'show'])->name('admin.classes.show');
    Route::get('/admin/classes/{class}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
    Route::put('/admin/classes/{class}', [ClassController::class, 'update'])->name('admin.classes.update');
    Route::delete('/admin/classes/{class}', [ClassController::class, 'destroy'])->name('admin.classes.destroy');
    
    // Admin Student Management (prefixed routes to avoid conflicts)
    Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/admin/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::get('/admin/students/{student}', [StudentController::class, 'show'])->name('admin.students.show');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::get('/admin/students/api', [StudentController::class, 'getStudents'])->name('admin.students.api');
    Route::post('/admin/students/{student}/transfer', [StudentController::class, 'transfer'])->name('admin.students.transfer');
    
    // Admin Grade Viewing (Read-Only)
    Route::get('/admin/grades/view-only', [GradeController::class, 'viewOnly'])->name('admin.grades.view.only');
    Route::get('/admin/grades/view-only/{classId}', [GradeController::class, 'viewOnly'])->name('admin.grades.view.only.class');
    Route::get('/admin/grades/view/{studentId?}', [GradeController::class, 'viewGrades'])->name('admin.grades.view');
    
    // Admin Book Management
    Route::get('/admin/books', [\App\Http\Controllers\BookController::class, 'index'])->name('admin.books.index');
    Route::get('/admin/books/issue', [\App\Http\Controllers\BookController::class, 'issueForm'])->name('admin.books.issue.form');
    Route::post('/admin/books/issue', [\App\Http\Controllers\BookController::class, 'issueBook'])->name('admin.books.issue');
    Route::get('/admin/books/return', [\App\Http\Controllers\BookController::class, 'returnForm'])->name('admin.books.return.form');
    Route::post('/admin/books/return', [\App\Http\Controllers\BookController::class, 'returnBook'])->name('admin.books.return');
    
    // Admin Attendance Reports
    Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/reports', [AttendanceController::class, 'reports'])->name('admin.attendance.reports');
    Route::post('/admin/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('admin.attendance.data');
});

// ============================================================================
// ADVISER ONLY ROUTES
// ============================================================================

Route::middleware(['auth', 'role:adviser'])->group(function () {
    // Adviser Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('adviser.dashboard');
    
    // Adviser Student Management (Their classes only)
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    
    // Adviser Attendance Management
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/daily/{classId?}', [AttendanceController::class, 'daily'])->name('attendance.daily');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');
    Route::post('/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');
    
    // Adviser Book Management (Their classes only)
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('adviser.books.index');
    Route::get('/books/issue', [\App\Http\Controllers\BookController::class, 'issueForm'])->name('adviser.books.issue.form');
    Route::post('/books/issue', [\App\Http\Controllers\BookController::class, 'issueBook'])->name('adviser.books.issue');
    Route::get('/books/return', [\App\Http\Controllers\BookController::class, 'returnForm'])->name('adviser.books.return.form');
    Route::post('/books/return', [\App\Http\Controllers\BookController::class, 'returnBook'])->name('adviser.books.return');
    
    // Adviser Grade Viewing (Read-Only, Their classes only)
    Route::get('/grades/view-only', [GradeController::class, 'viewOnly'])->name('adviser.grades.view.only');
    Route::get('/grades/view-only/{classId}', [GradeController::class, 'viewOnly'])->name('adviser.grades.view.only.class');
    
    // AJAX endpoint for getting class students
    Route::get('/sf/class/{classId}/students', [SFController::class, 'getClassStudents'])->name('sf.class.students');
});

// ============================================================================
// TEACHER ONLY ROUTES
// ============================================================================

Route::middleware(['auth', 'role:teacher'])->group(function () {
    // Teacher Portal Dashboard
    Route::get('/teacher-portal', function () {
        return view('teacher-portal.index');
    })->name('teacher.dashboard');
    
    // Teacher Class Viewing
    Route::get('/teacher-portal/classes', function () {
        return view('classes.index');
    })->name('teacher.classes');
    Route::get('/teacher-portal/classes/{id}', function () {
        return view('classes.view');
    })->name('teacher.classes.view');
    
    // Teacher Grade Encoding (Full Access)
    Route::get('/grades', [GradeController::class, 'encode'])->name('grades.encode');
    Route::get('/grades/encode', [GradeController::class, 'encode'])->name('grades.encode.form');
    Route::get('/grades/encode/{classId}', [GradeController::class, 'encode'])->name('grades.encode.class');
    Route::post('/grades/store', [GradeController::class, 'store'])->name('grades.store');
    Route::post('/grades/calculate-final', [GradeController::class, 'calculateFinalGrades'])->name('grades.calculate');
    
    // Teacher Portal Grade Routes
    Route::get('/teacher-portal/grades/encode', [GradeController::class, 'encode'])->name('teacher.grades.encode');
    Route::get('/teacher-portal/grades/encode/{classId}', [GradeController::class, 'encode'])->name('teacher.grades.encode.class');
    Route::get('/teacher-portal/grades/quarterly', [GradeController::class, 'encode'])->name('teacher.grades.quarterly');
    
    // Teacher Reports
    Route::get('/teacher-portal/reports', function () {
        return view('teacher-portal.index');
    })->name('teacher.reports');
    
    // Teacher Attendance Viewing
    Route::get('/teacher-portal/attendance', function () {
        return view('teacher-portal.index');
    })->name('teacher.attendance');
});

// ============================================================================
// STUDENT ONLY ROUTES
// ============================================================================

Route::middleware(['auth', 'role:student'])->group(function () {
    // Student Portal
    Route::get('/portal/grades', [StudentController::class, 'grades'])->name('student.grades');
    
    // Student Grade Viewing (Their own grades only)
    Route::get('/grades/view/{studentId?}', [GradeController::class, 'viewGrades'])->name('student.grades.view');
});

// ============================================================================
// SHARED ROUTES (Admin and Adviser with Proper Access Control)
// ============================================================================

// Class Management Routes (Admin and Adviser both can access with controller-level restrictions)
Route::middleware(['auth', 'role:admin,adviser'])->group(function () {
    // Shared Class Management
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index'); 
    Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');
    Route::get('/classes/api', [ClassController::class, 'getClasses'])->name('classes.api');
});

// ============================================================================
// SHARED ROUTES (Multiple Roles with Proper Access Control)
// ============================================================================

// Admin and Adviser can access these with role-specific restrictions handled in controllers
Route::middleware(['auth', 'role:admin,adviser'])->group(function () {
    // School Forms Access (Admin and Adviser)
    Route::get('/sf/sf1', [SFController::class, 'sf1'])->name('sf.sf1');
    Route::get('/sf/sf2', [SFController::class, 'sf2'])->name('sf.sf2');
    Route::get('/sf/sf3', [SFController::class, 'sf3'])->name('sf.sf3');
    Route::get('/sf/sf5', [SFController::class, 'sf5'])->name('sf.sf5');
    Route::get('/sf/sf8', [SFController::class, 'sf8'])->name('sf.sf8');
    Route::post('/sf/sf8', [SFController::class, 'sf8Store'])->name('sf8.store');
    Route::get('/sf/sf9', [SFController::class, 'sf9'])->name('sf.sf9');
    Route::get('/sf/sf10', [SFController::class, 'sf10'])->name('sf.sf10');
    
    // Grade Viewing Access (Admin and Adviser - Read Only)
    Route::get('/grades/view-only', [GradeController::class, 'viewOnly'])->name('grades.view.only');
    Route::get('/grades/view-only/{classId}', [GradeController::class, 'viewOnly'])->name('grades.view.only.class');
    
    // Explicitly define adviser grade viewing routes to ensure they're registered
    Route::get('/grades/view-only', [GradeController::class, 'viewOnly'])->name('adviser.grades.view.only');
    Route::get('/grades/view-only/{classId}', [GradeController::class, 'viewOnly'])->name('adviser.grades.view.only.class');
    
    // Shared transfers and data corrections (with role-based restrictions in controllers)
    Route::get('/transfers', function () {
        return view('transfers.index');
    })->name('transfers.index');
    
    Route::get('/data-corrections', function () {
        return view('data-corrections.index');
    })->name('data-corrections.index');
    
    Route::get('/support', function () {
        return view('support.index');
    })->name('support.index');
});

// ============================================================================
// LEGACY AND COMPATIBILITY ROUTES (With Proper Role Protection)
// ============================================================================

// Legacy SF routes for backward compatibility (Admin and Adviser only)
Route::middleware(['auth', 'role:admin,adviser'])->group(function () {
    Route::get('/sf1', [SFController::class, 'sf1'])->name('sf1');
    Route::get('/sf2', [SFController::class, 'sf2'])->name('sf2');
    Route::get('/sf3', [SFController::class, 'sf3'])->name('sf3');
    Route::get('/sf5', [SFController::class, 'sf5'])->name('sf5');
    Route::get('/sf9', [SFController::class, 'sf9'])->name('sf9');
    Route::get('/sf10', [SFController::class, 'sf10'])->name('sf10');
    
    // Add the missing sf.* named routes that views are looking for
    Route::get('/sf/sf2', [SFController::class, 'sf2'])->name('sf.sf2');
    Route::get('/sf/sf3', [SFController::class, 'sf3'])->name('sf.sf3');
    Route::get('/sf/sf5', [SFController::class, 'sf5'])->name('sf.sf5');
    Route::get('/sf/sf9', [SFController::class, 'sf9'])->name('sf.sf9');
    Route::get('/sf/sf10', [SFController::class, 'sf10'])->name('sf.sf10');
    
    // Generate endpoints redirect to main SF routes
    Route::get('/sf/sf1/generate', [SFController::class, 'sf1']);
    Route::get('/sf/sf2/generate', [SFController::class, 'sf2']);
    Route::get('/sf/sf3/generate', [SFController::class, 'sf3']);
    Route::get('/sf/sf5/generate', [SFController::class, 'sf5']);
    Route::get('/sf/sf9/generate', [SFController::class, 'sf9']);
    Route::get('/sf/sf10/generate', [SFController::class, 'sf10']);
    
    Route::get('/sf1/generate', [SFController::class, 'sf1']);
    Route::get('/sf2/generate', [SFController::class, 'sf2']);
    Route::get('/sf3/generate', [SFController::class, 'sf3']);
    Route::get('/sf5/generate', [SFController::class, 'sf5']);
    Route::get('/sf9/generate', [SFController::class, 'sf9']);
    Route::get('/sf10/generate', [SFController::class, 'sf10']);
});

// Excel Export Routes (Admin and Adviser only)
Route::middleware(['auth', 'role:admin,adviser'])->group(function () {
    Route::get('/excel/sf1', function () {
        return redirect('/sf/sf1');
    })->name('excel.sf1');

    Route::get('/excel/sf2', function () {
        return redirect('/sf/sf2');
    })->name('excel.sf2');

    Route::get('/excel/sf3', function () {
        return redirect('/sf/sf3');
    })->name('excel.sf3');

    Route::get('/excel/sf5', function () {
        return redirect('/sf/sf5');
    })->name('excel.sf5');

    Route::get('/excel/sf9', function () {
        return redirect('/sf/sf9');
    })->name('excel.sf9');

    Route::get('/excel/sf9/bulk', function () {
        return redirect('/sf/sf9');
    })->name('excel.sf9.bulk');

    Route::get('/excel/sf10', function () {
        return redirect('/sf/sf10');
    })->name('excel.sf10');
});