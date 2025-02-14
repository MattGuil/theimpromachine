<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController
{
    public function index() {
        $user = Auth::user();
        $games = app(GameController::class)->getGamesByArbitre($user->name);

        return view('home', [
            'games' => $games
        ]);
    }

    public function game($id) {
        $user = Auth::user();
        $game = app(GameController::class)->getGame($id, $user->name);

        if ($game) {
            return view('game', [
                'game' => $game,
                'impros' => app(ImproController::class)->getImprosByGame($game->id)
            ]);
        } else {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à ce match.');
        }
    }

    public function play($id) {
        $user = Auth::user();
        $game = app(GameController::class)->getGame($id, $user->name);

        if ($game) {
            return view('play', [
                'game' => $game,
                'impros' => app(ImproController::class)->getImprosByGame($game->id)
            ]);
        } else {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à ce match.');
        }
    }
}