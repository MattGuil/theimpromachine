<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController
{
    /**
     * Afficher la page d'accueil avec la liste des matchs arbitrés par l'utilisateur connecté.
     */
    public function index() {
        $user = Auth::user();
        $games = app(GameController::class)->getGamesByArbitre($user->name);

        return view('home', [
            'games' => $games
        ]);
    }

    /**
     * Afficher la page présentant la composition (improvisations) d'un match spécifique.
     */
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

    /**
     * Afficher la page de déroulement d'un match spécifique.
     */
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

    /**
     * Afficher la page d'aide présentant les règles et les catégories de l'improvisation théâtrale.
     */
    public function help() {
        $categories = app(CategorieController::class)->getCategoriesByType();

        return view('help', [
            'categories' => $categories,
        ]);
    }
}