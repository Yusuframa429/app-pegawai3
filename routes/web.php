<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


// 1. Import Controller-nya dulu di bagian atas file
use App\Http\Controllers\UserController;

// 2. Daftarkan semua 7 URL CRUD sekaligus
Route::resource('users', UserController::class);

// 1. Import Controller-nya dulu di bagian atas file
use App\Http\Controllers\EmployeeController;

// 2. Daftarkan semua 7 URL CRUD sekaligus
Route::resource('employees', EmployeeController::class);


// 1. Import Controller-nya dulu di bagian atas file
use App\Http\Controllers\DepartmentController;

// 2. Daftarkan semua 7 URL CRUD sekaligus
Route::resource('departments', DepartmentController::class);

// 1. Import Controller-nya dulu di bagian atas file
use App\Http\Controllers\PositionController;

// 2. Daftarkan semua 7 URL CRUD sekaligus
Route::resource('positions', PositionController::class);
