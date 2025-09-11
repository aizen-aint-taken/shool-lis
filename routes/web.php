<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SFController;

// Authentication Routes
Route::view('/', 'portal.login');
Route::get('/login', function () {
    return view('portal.login');
})->name('login');
Route::view('/portal/login', 'portal.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Student Portal Routes
Route::view('/portal/grades', 'portal.grades');

// Public API route for grade viewing (no auth required since controller handles it)
Route::get('/grades/student/{studentId}', [GradeController::class, 'getStudentGrades'])->name('grades.student');

// Dashboard Routes
Route::view('/dashboard', 'dashboard.index');
Route::view('/transfers', 'transfers.index');
Route::view('/data-corrections', 'data-corrections.index');
Route::view('/support', 'support.index');

// Class Management Routes (Admin/Adviser only)
Route::middleware(['auth'])->group(function () {
    Route::resource('classes', ClassController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/classes/api', [ClassController::class, 'getClasses'])->name('classes.api');
});

// Student Management Routes (Admin/Adviser only) 
Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/students/api', [StudentController::class, 'getStudents'])->name('students.api');
    Route::post('/students/{student}/transfer', [StudentController::class, 'transfer'])->name('students.transfer');
});

// Subject Teacher Portal Routes
Route::view('/teacher-portal', 'teacher-portal.index');
Route::view('/teacher-portal/classes', 'classes.index');
Route::view('/teacher-portal/classes/{id}', 'classes.view');
Route::view('/teacher-portal/reports', 'teacher-portal.index');
Route::view('/teacher-portal/attendance', 'teacher-portal.index');

// Grade Encoding Routes (Teacher Portal only)
Route::middleware(['auth'])->group(function () {
    // Teacher-only grade encoding
    Route::get('/grades', [GradeController::class, 'encode'])->name('grades.encode');
    Route::get('/grades/encode', [GradeController::class, 'encode'])->name('grades.encode.form');
    Route::get('/grades/encode/{classId}', [GradeController::class, 'encode'])->name('grades.encode.class');
    Route::post('/grades/store', [GradeController::class, 'store'])->name('grades.store');
    Route::post('/grades/calculate-final', [GradeController::class, 'calculateFinalGrades'])->name('grades.calculate');

    // Grade viewing for admin and advisers (read-only)
    Route::get('/grades/view-only', [GradeController::class, 'viewOnly'])->name('grades.view.only');
    Route::get('/grades/view-only/{classId}', [GradeController::class, 'viewOnly'])->name('grades.view.only.class');
    
    // Grade viewing (admin, adviser, student access)
    Route::get('/grades/view/{studentId?}', [GradeController::class, 'viewGrades'])->name('grades.view');

    // Teacher portal grade routes
    Route::get('/teacher-portal/grades/encode', [GradeController::class, 'encode'])->name('teacher.grades.encode');
    Route::get('/teacher-portal/grades/encode/{classId}', [GradeController::class, 'encode'])->name('teacher.grades.encode.class');
    Route::get('/teacher-portal/grades/quarterly', [GradeController::class, 'encode'])->name('teacher.grades.quarterly');
});

// School Forms Routes - Dynamic with database data
Route::middleware(['auth'])->group(function () {
    Route::get('/sf/sf1', [SFController::class, 'sf1'])->name('sf.sf1');
    Route::get('/sf/sf2', [SFController::class, 'sf2'])->name('sf.sf2');
    Route::get('/sf/sf3', [SFController::class, 'sf3'])->name('sf.sf3');
    Route::get('/sf/sf5', [SFController::class, 'sf5'])->name('sf.sf5');
    Route::get('/sf/sf9', [SFController::class, 'sf9'])->name('sf.sf9');
    Route::get('/sf/sf10', [SFController::class, 'sf10'])->name('sf.sf10');
    
    // AJAX endpoint for getting class students
    Route::get('/sf/class/{classId}/students', [SFController::class, 'getClassStudents'])->name('sf.class.students');
});

// Legacy routes for backward compatibility
Route::middleware(['auth'])->group(function () {
    Route::get('/sf1', [SFController::class, 'sf1']);
    Route::get('/sf2', [SFController::class, 'sf2']);
    Route::get('/sf3', [SFController::class, 'sf3']);
    Route::get('/sf5', [SFController::class, 'sf5']);
    Route::get('/sf9', [SFController::class, 'sf9']);
    Route::get('/sf10', [SFController::class, 'sf10']);
});

// Additional SF Form Routes (Generate endpoints redirect to main SF routes)
Route::middleware(['auth'])->group(function () {
    Route::get('/sf/sf1/generate', [SFController::class, 'sf1']);
    Route::get('/sf/sf2/generate', [SFController::class, 'sf2']);
    Route::get('/sf/sf3/generate', [SFController::class, 'sf3']);
    Route::get('/sf/sf5/generate', [SFController::class, 'sf5']);
    Route::get('/sf/sf9/generate', [SFController::class, 'sf9']);
    Route::get('/sf/sf10/generate', [SFController::class, 'sf10']);
    
    // Legacy generate routes
    Route::get('/sf1/generate', [SFController::class, 'sf1']);
    Route::get('/sf2/generate', [SFController::class, 'sf2']);
    Route::get('/sf3/generate', [SFController::class, 'sf3']);
    Route::get('/sf5/generate', [SFController::class, 'sf5']);
    Route::get('/sf9/generate', [SFController::class, 'sf9']);
    Route::get('/sf10/generate', [SFController::class, 'sf10']);
});

// Excel Export Routes (redirect to SF forms)
Route::middleware(['auth'])->group(function () {
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
