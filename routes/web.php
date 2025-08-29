<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::view('/', 'portal.login');
Route::view('/portal/login', 'portal.login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Student Portal Routes
Route::view('/portal/grades', 'portal.grades');

// Adviser Dashboard Routes
Route::view('/dashboard', 'dashboard.index');

// Class Management Routes
Route::view('/classes', 'classes.index');
Route::view('/classes/create', 'classes.create');
Route::view('/classes/edit', 'classes.edit');
Route::view('/classes/{id}/view', 'classes.view');
Route::view('/classes/{id}/edit', 'classes.edit');

// Student Management Routes
Route::view('/students', 'students.index');
Route::view('/students/create', 'students.create');
Route::view('/students/edit', 'students.edit');
Route::view('/students/{id}/view', 'students.view');
Route::view('/students/{id}/edit', 'students.edit');

// Grade Encoding Routes
Route::view('/grades', 'grades.encode');
Route::view('/grades/encode', 'grades.encode');
Route::view('/grades/encode/{classId}', 'grades.encode');

// School Forms Routes
Route::view('/sf9', 'sf.sf9');
Route::view('/sf10', 'sf.sf10');
Route::view('/sf1', 'sf.sf1');

// Additional SF Form Routes
Route::view('/sf9/generate', 'sf.sf9');
Route::view('/sf10/generate', 'sf.sf10');
Route::view('/sf1/generate', 'sf.sf1');
