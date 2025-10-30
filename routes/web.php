<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\DashboardController;

// Arahkan halaman utama ke daftar pegawai (contoh)
Route::get('/', function () {
    return redirect()->route('employees.index');
});
Route::get('/', function () {
    return redirect()->route('dashboard'); // <-- MENJADI 'dashboard'
});

// Ini adalah semua rute CRUD admin kamu
Route::resource('users', UserController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionController::class);
Route::resource('attendences', AttendenceController::class);
Route::resource('salaries', SalaryController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
