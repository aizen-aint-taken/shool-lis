<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::view('/', 'portal.login');
Route::view('/portal/login', 'portal.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Student Portal Routes
Route::view('/portal/grades', 'portal.grades');

// Dashboard Routes
Route::view('/dashboard', 'dashboard.index');
Route::view('/transfers', 'transfers.index');
Route::view('/data-corrections', 'data-corrections.index');
Route::view('/support', 'support.index');

// Class Management Routes (Admin/Adviser only)
Route::view('/classes', 'classes.index');
Route::view('/classes/create', 'classes.create');
Route::view('/classes/{id}/view', 'classes.view');
Route::view('/classes/{id}/edit', 'classes.edit');

// Subject Teacher Portal Routes
Route::view('/teacher-portal', 'teacher-portal.index');
Route::view('/teacher-portal/grades/encode', 'grades.encode');
Route::view('/teacher-portal/grades/encode/{classId}', 'grades.encode');
Route::view('/teacher-portal/grades/quarterly', 'grades.quarterly-encode');
Route::view('/teacher-portal/classes', 'classes.index');
Route::view('/teacher-portal/classes/{id}', 'classes.view');
Route::view('/teacher-portal/reports', 'teacher-portal.index');
Route::view('/teacher-portal/attendance', 'teacher-portal.index');

// Grade Encoding Routes (Teacher Portal only)
Route::view('/grades', 'grades.encode');
Route::view('/grades/encode', 'grades.encode');
Route::view('/grades/encode/{classId}', 'grades.encode');
Route::view('/grades/quarterly', 'grades.quarterly-encode');

// School Forms Routes
Route::view('/sf/sf1', 'sf.sf1');
Route::view('/sf/sf2', 'sf.sf2'); // New: Enrollment & Attendance
Route::view('/sf/sf3', 'sf.sf3'); // New: Books/Textbooks Monitoring
Route::view('/sf/sf5', 'sf.sf5'); // Updated: Promotions & Proficiency Levels
Route::view('/sf/sf9', 'sf.sf9'); // Updated: Report Card (Quarterly/Yearly)
Route::view('/sf/sf10', 'sf.sf10'); // Updated: Permanent Academic Record

// Legacy routes for backward compatibility
Route::view('/sf1', 'sf.sf1');
Route::view('/sf2', 'sf.sf2');
Route::view('/sf3', 'sf.sf3');
Route::view('/sf5', 'sf.sf5');
Route::view('/sf9', 'sf.sf9');
Route::view('/sf10', 'sf.sf10');

// Additional SF Form Routes
Route::view('/sf/sf1/generate', 'sf.sf1');
Route::view('/sf/sf2/generate', 'sf.sf2');
Route::view('/sf/sf3/generate', 'sf.sf3');
Route::view('/sf/sf5/generate', 'sf.sf5');
Route::view('/sf/sf9/generate', 'sf.sf9');
Route::view('/sf/sf10/generate', 'sf.sf10');

// Legacy generate routes
Route::view('/sf1/generate', 'sf.sf1');
Route::view('/sf2/generate', 'sf.sf2');
Route::view('/sf3/generate', 'sf.sf3');
Route::view('/sf5/generate', 'sf.sf5');
Route::view('/sf9/generate', 'sf.sf9');
Route::view('/sf10/generate', 'sf.sf10');

// Excel Export Routes
Route::get('/excel/sf1', function() {
    return redirect('/sf1');
})->name('excel.sf1');

Route::get('/excel/sf2', function() {
    return redirect('/sf2');
})->name('excel.sf2');

Route::get('/excel/sf3', function() {
    return redirect('/sf3');
})->name('excel.sf3');

Route::get('/excel/sf5', function() {
    return redirect('/sf5');
})->name('excel.sf5');

Route::get('/excel/sf9', function() {
    return redirect('/sf9');
})->name('excel.sf9');

Route::get('/excel/sf9/bulk', function() {
    return redirect('/sf9');
})->name('excel.sf9.bulk');

Route::get('/excel/sf10', function() {
    return redirect('/sf10');
})->name('excel.sf10');
