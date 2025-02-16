<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ImproController;


Route::get('/', function() {
    return redirect()->route('login');
});

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::get('login', [AuthController::class, 'showLogin'])->name('login');

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::match(['get', 'delete'], 'logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
Route::get('home', [AppController::class, 'index'])->name('home')->middleware('auth');
Route::get('game/{i}', [AppController::class, 'game'])->name('game')->middleware('auth');
Route::get('play/{i}', [AppController::class, 'play'])->name('play')->middleware('auth');

Route::post('generategame', [GameController::class, 'generateGame'])->middleware('auth');
Route::delete('deletegame/{id}', [GameController::class, 'deleteGame'])->middleware('auth');

Route::delete('deleteimpro/{id}', [ImproController::class, 'deleteImpro'])->middleware('auth');
Route::post('updateimprosorder', [ImproController::class, 'updateImprosOrder'])->middleware('auth');
