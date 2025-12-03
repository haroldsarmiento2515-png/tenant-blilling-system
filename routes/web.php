<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// User Authentication Routes
Route::get('/login', [AuthController::class, 'showUserLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'userLogin']);
Route::get('/register', [AuthController::class, 'showUserRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'userRegister']);
Route::get('/email/verify', [AuthController::class, 'showVerificationForm'])->name('verification.notice');
Route::post('/email/verify', [AuthController::class, 'verifyOtp']);

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Protected routes
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/user-chart-data', [DashboardController::class, 'getUserChartData']);
    Route::get('/admin/dashboard/billing-chart-data', [DashboardController::class, 'getBillingChartData']);
});