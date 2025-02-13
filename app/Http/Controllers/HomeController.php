<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Impro;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index() {
        return view('home', [
            'games' => Game::all()
        ]);
    }

    public function newPost(Request $request) {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
            ]);
    
            $data = new Post([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);
    
            $data->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Post created successfully',
                'post' => $data,
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the post',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function newGame(Request $request) {
        try {
            $data = new Game([
                'equipe_1' => $request['equipe_1'],
                'equipe_2' => $request['equipe_2'],
                'equipe_1_score' => $request['equipe_1_score'],
                'equipe_2_score' => $request['equipe_2_score'],
                'statut' => $request['statut'],
                'vainqueur' => $request['vainqueur'],
            ]);
    
            $data->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Game created successfully',
                'game' => $data,
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the game',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function newImpro(Request $request) {
        try {
            $data = new Impro([
                'game_id' => $request['game_id'],
                'type' => $request['type'],
                'nb_joueur' => $request['nb_joueur'],
                'duree' => $request['duree'],
                'categorie_id' => $request['categorie_id'],
                'theme' => $request['theme'],
                'statut' => $request['statut']
            ]);
    
            $data->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Impro created successfully',
                'impro' => $data,
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the impro',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}