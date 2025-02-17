<?php

namespace App\Http\Controllers;

use App\Models\Impro;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ImproController
{
    public function generateImpro($game_id, $position, $nb_joueurs, $nb_impros, $theme) {
        $type = (rand(1, 4) <= 3) ? 'Mixte' : 'Comparée';
        $nb_joueurs = (rand(1, 10) <= 8) ? -1 : rand(2, $nb_joueurs - 1);
        $duree = (rand(1, 10) <= 8) ? rand(2, 7) : rand(1, 15);
        $categorie_id = (rand(1, 10) <= 8) ? 1 : Categorie::where('id', '!=', 1)->inRandomOrder()->first()->id;

        $impro = new Impro([
            'game_id' => $game_id,
            'position' => $position,
            'type' => $type,
            'nb_joueurs' => $nb_joueurs,
            'duree' => $duree,
            'categorie_id' => $categorie_id,
            'theme' => $theme,
            'vainqueur' => null
        ]);

        $impro->save();
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

    public function getImprosByGame($gameId) {
        return Impro::where('game_id', $gameId)->orderBy('position', 'asc')->get();
    }

    public function updateImprosOrder(Request $request) {
        $order = $request->input('order');
        foreach ($order as $item) {
            Impro::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function updateImproWinner(Request $request) {
        $improId = $request->input('impro_id');
        $winner = $request->input('winner');

        Impro::where('id', $improId)->update(['vainqueur' => $winner]);

        return response()->json(['status' => 'success']);
    }

    public function hasImproWinner($id) {
        $impro = Impro::findOrFail($id);
        return response()->json(['has_winner' => !is_null($impro->vainqueur)]);
    }
}
