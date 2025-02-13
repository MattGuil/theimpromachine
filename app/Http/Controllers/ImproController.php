<?php

namespace App\Http\Controllers;

use App\Models\Impro;
use Illuminate\Http\Request;

class ImproController
{
    public function createImpro(Request $request) {
        try {
            $validatedData = $request->validate([
                'game_id' => 'required|integer|exists:games,id',
                'type' => 'required|in:Mixte,Comparée',
                'nb_joueur' => 'required|integer',
                'duree' => 'required|integer',
                'categorie_id' => 'required|integer|exists:categories,id',
                'theme' => 'required|string|max:255',
                'statut' => 'required|in:Créée,En cours,Jouée',
            ]);

            $data = new Impro([
                'game_id' => $validatedData['game_id'],
                'type' => $validatedData['type'],
                'nb_joueur' => $validatedData['nb_joueur'],
                'duree' => $validatedData['duree'],
                'categorie_id' => $validatedData['categorie_id'],
                'theme' => $validatedData['theme'],
                'statut' => $validatedData['statut']
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

    public function deleteImpro($id) {
        try {
            $impro = Impro::findOrFail($id);
            $impro->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Impro deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the impro',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
