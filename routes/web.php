<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;

// ── AUTH ──────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── DASHBOARD ─────────────────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ── SUBJECTS (browse) ─────────────────────────────────────────────────────────
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

// ── ENROLLMENT ────────────────────────────────────────────────────────────────
Route::get('/enroll', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::delete('/enroll/{id}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
Route::post('/enroll/confirm', [EnrollmentController::class, 'confirm'])->name('enrollments.confirm');
