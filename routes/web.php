<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ImproController;

// Redirection vers la page de login
Route::get('/', function() {
    return redirect()->route('login');
});

// Routes pour l'authentification
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::match(['get', 'delete'], 'logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Routes pour l'application principale
Route::get('home', [AppController::class, 'index'])->name('home')->middleware('auth');
Route::get('game/{i}', [AppController::class, 'game'])->name('game')->middleware('auth');
Route::get('play/{i}', [AppController::class, 'play'])->name('play')->middleware('auth');
Route::get('help', [AppController::class, 'help'])->name('help')->middleware('auth');

// Routes pour la gestion des matchs
Route::post('generategame', [GameController::class, 'generateGame'])->middleware('auth');
Route::post('resetgame/{id}', [GameController::class, 'resetGame'])->middleware('auth');
Route::delete('deletegame/{id}', [GameController::class, 'deleteGame'])->middleware('auth');
Route::post('updategamewinner/{id}', [GameController::class, 'updateGameWinner'])->middleware('auth');
Route::get('gameresults/{id}', [GameController::class, 'getGameResults'])->middleware('auth');

// Routes pour la gestion des impros
Route::delete('deleteimpro/{id}', [ImproController::class, 'deleteImpro'])->middleware('auth');
Route::post('updateimprosorder', [ImproController::class, 'updateImprosOrder'])->middleware('auth');
Route::post('updateimprowinner', [ImproController::class, 'updateImproWinner'])->middleware('auth');
Route::get('hasimprowinner/{id}', [ImproController::class, 'hasImproWinner'])->middleware('auth');
