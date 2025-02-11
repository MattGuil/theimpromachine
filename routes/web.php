<?php

use Illuminate\Support\Facades\Http;
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

Route::post('newpost', [HomeController::class, 'newPost'])->middleware('auth');
Route::post('newgame', [HomeController::class, 'newGame'])->middleware('auth');
Route::post('newimpro', [HomeController::class, 'newImpro'])->middleware('auth');

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