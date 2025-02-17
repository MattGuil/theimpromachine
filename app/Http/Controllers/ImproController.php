<?php

namespace App\Http\Controllers;

use App\Models\Impro;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ImproController
{
    /**
     * Générer une nouvelle improvisation.
     */
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

    /**
     * Supprimer une improvisation par ID.
     */
    public function deleteImpro($id) {
        try {
            $impro = Impro::findOrFail($id);
            $impro->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Impro supprimée avec succès',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur est survenue lors de la suppression de l\'impro',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtenir toutes les improvisations d'un match spécifique.
     */
    public function getImprosByGame($gameId) {
        return Impro::where('game_id', $gameId)->orderBy('position', 'asc')->get();
    }

    /**
     * Mettre à jour l'ordre des improvisations dans la composition d'un match.
     */
    public function updateImprosOrder(Request $request) {
        $order = $request->input('order');
        foreach ($order as $item) {
            Impro::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Mettre à jour le vainqueur d'une improvisation.
     */
    public function updateImproWinner(Request $request) {
        $improId = $request->input('impro_id');
        $winner = $request->input('winner');

        Impro::where('id', $improId)->update(['vainqueur' => $winner]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Vérifier si une improvisation a un vainqueur, autrement dit, si elle a été jouée.
     */
    public function hasImproWinner($id) {
        $impro = Impro::findOrFail($id);
        return response()->json(['has_winner' => !is_null($impro->vainqueur)]);
    }
}
