<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController
{
    public function createGame(Request $request) {
        try {
            $validatedData = $request->validate([
                'arbitre' => 'required|string|max:25',
                'equipe_1' => 'required|string|max:255',
                'equipe_2' => 'required|string|max:255',
                'equipe_1_score' => 'nullable|integer',
                'equipe_2_score' => 'nullable|integer',
                'statut' => 'required|in:Créée,En cours,Terminée',
                'vainqueur' => 'nullable|string|max:255',
            ]);

            $data = new Game([
                'arbitre' => $validatedData['arbitre'],
                'equipe_1' => $validatedData['equipe_1'],
                'equipe_2' => $validatedData['equipe_2'],
                'equipe_1_score' => $validatedData['equipe_1_score'],
                'equipe_2_score' => $validatedData['equipe_2_score'],
                'statut' => $validatedData['statut'],
                'vainqueur' => $validatedData['vainqueur'],
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

    public function deleteGame($id) {
        try {
            $game = Game::findOrFail($id);
            $game->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Game deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the game',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getGamesByArbitre($arbitre) {
        return Game::where('arbitre', $arbitre)->get();
    }

    public function getGame($gameId, $userId) {
        return Game::where('id', $gameId)->where('arbitre', $userId)->first();
    }
}
