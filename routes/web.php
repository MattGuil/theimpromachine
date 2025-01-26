<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', function() {
    return redirect()->route('login');
});

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::get('login', [AuthController::class, 'showLogin'])->name('login');

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::match(['get', 'delete'], 'logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('ajaxupload', [HomeController::class, 'upload']);