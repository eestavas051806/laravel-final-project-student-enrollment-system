<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// ── AUTH ──────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── STUDENT DASHBOARD ─────────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ── SUBJECTS (browse) ─────────────────────────────────────────────────────────
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

// ── ENROLLMENT ────────────────────────────────────────────────────────────────
Route::get('/enroll', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::delete('/enroll/{id}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
Route::post('/enroll/confirm', [EnrollmentController::class, 'confirm'])->name('enrollments.confirm');

// ── PROFILE ───────────────────────────────────────────────────────────────────
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');

// ── ADMIN ─────────────────────────────────────────────────────────────────────
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin - Students
Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
Route::get('/admin/students/{student}', [AdminController::class, 'showStudent'])->name('admin.students.show');
Route::get('/admin/students/{student}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
Route::patch('/admin/students/{student}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
Route::delete('/admin/students/{student}', [AdminController::class, 'destroyStudent'])->name('admin.students.destroy');

// Admin - Subjects
Route::get('/admin/subjects', [AdminController::class, 'subjects'])->name('admin.subjects');
Route::get('/admin/subjects/create', [AdminController::class, 'createSubject'])->name('admin.subjects.create');
Route::post('/admin/subjects', [AdminController::class, 'storeSubject'])->name('admin.subjects.store');
Route::get('/admin/subjects/{subject}/edit', [AdminController::class, 'editSubject'])->name('admin.subjects.edit');
Route::patch('/admin/subjects/{subject}', [AdminController::class, 'updateSubject'])->name('admin.subjects.update');
Route::delete('/admin/subjects/{subject}', [AdminController::class, 'destroySubject'])->name('admin.subjects.destroy');

// Admin - Enrollments (view only)
Route::get('/admin/enrollments', [AdminController::class, 'enrollments'])->name('admin.enrollments');
