<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index() {
        $user = Auth::user();
        $games = app(GameController::class)->getGamesByArbitre($user->name);

        return view('home', [
            'games' => $games
        ]);
    }
}