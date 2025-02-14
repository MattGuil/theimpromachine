<?php

use Illuminate\Support\Facades\Http;
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

Route::post('creategame', [GameController::class, 'createGame'])->middleware('auth');
Route::delete('deletegame/{id}', [GameController::class, 'deleteGame'])->middleware('auth');

Route::post('createimpro', [ImproController::class, 'createImpro'])->middleware('auth');
Route::delete('deleteimpro/{id}', [ImproController::class, 'deleteImpro'])->middleware('auth');
Route::post('updateimprosorder', [ImproController::class, 'updateImprosOrder'])->middleware('auth');


Route::get('/openai', function() {

    $numberOfThemes = request('count', 5);
    $prompt = "Génère une liste de $numberOfThemes thèmes pour un match d'improvisation théâtrale. Assure-toi que les thèmes sont variés et intéressants. Un thème est une phrase courte (4-5 mots maximum) et souvent abstraite. Exemple : Amour à la carte";
    
    $response = Http::withToken(config('services.openai.secret'))
        ->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Tu es un assistant créatif et tu génères des idées pour des matchs d\'improvisation théâtrale.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'response',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'themes' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'string'
                                ]
                            ]
                        ],
                        "required" => [
                            "themes"
                        ],
                        "additionalProperties" => false
                    ]
                ]
            ]
        ])->json();
        
    dd(json_decode($response['choices'][0]['message']['content']));
});