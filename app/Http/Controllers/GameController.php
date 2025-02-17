<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Impro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController
{
    /**
     * Générer un nouveau match et ses improvisations.
     */
    public function generateGame(Request $request) {
        try {
            $validatedData = $request->validate([
                'arbitre' => 'required|string|max:25',
                'equipe_1' => 'required|string|max:255',
                'equipe_2' => 'required|string|max:255',
                'nb_joueurs' => 'required|integer|min:4|max:20',
                'nb_impros' => 'required|integer|min:5|max:15',
            ]);

            $game = new Game([
                'arbitre' => $validatedData['arbitre'],
                'equipe_1' => $validatedData['equipe_1'],
                'equipe_2' => $validatedData['equipe_2'],
                'vainqueur' => null,
            ]);

            $game->save();

            $numberOfThemes = $validatedData['nb_impros'];
            $prompt = "Génère une liste de $numberOfThemes thèmes pour un match d'improvisation théâtrale. Assure-toi que les thèmes sont variés et intéressants. Un thème est une phrase courte (4-5 mots maximum) et souvent abstraite.";
            $numberOfThemes = (int) $numberOfThemes;

            // Appel à l'API OpenAI pour générer les thèmes
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

            // Extraire les thèmes générés de la réponse
            $themes = json_decode($response['choices'][0]['message']['content'], true)['themes'];

            // Si la réponse est valide, continuer à créer les impros
            if ($themes && is_array($themes) && count($themes) >= $numberOfThemes) {
                // Créer les impros avec les thèmes générés
                for ($i = 0; $i < $numberOfThemes; $i++) {
                    app(ImproController::class)->generateImpro(
                        $game->id,
                        $i + 1,
                        $validatedData['nb_joueurs'],
                        $validatedData['nb_impros'],
                        $themes[$i] // Utiliser le thème généré pour chaque impro
                    );
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Jeu et improvisations créés avec succès',
                'game' => $game,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur est survenue lors de la création du jeu',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Réinitialiser le vainqueur d'un match et de ses improvisations.
     */
    public function resetGame($id) {
        try {
            $game = Game::findOrFail($id);
            Impro::where('game_id', $id)->update(['vainqueur' => null]);
            $game->update(['vainqueur' => null]);

            return response()->json([
                'status' => 200,
                'message' => 'Jeu et improvisations réinitialisés avec succès',
                'game' => $game,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur est survenue lors de la réinitialisation du jeu',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprimer un match et les improvisations qui le composent.
     */
    public function deleteGame($id) {
        try {
            $game = Game::findOrFail($id);
            $gameDeleted = $game;
            Impro::where('game_id', $id)->delete();
            $game->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Jeu et improvisations associées supprimés avec succès',
                'game' => $gameDeleted,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur est survenue lors de la suppression du jeu',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtenir tous les matchs arbitrés par un utilisateur donné.
     */
    public function getGamesByArbitre($arbitre) {
        return Game::where('arbitre', $arbitre)->get();
    }

    /**
     * Obtenir un match spécifique par son ID et le nom de l'arbitre.
     */
    public function getGame($gameId, $userId) {
        return Game::where('id', $gameId)->where('arbitre', $userId)->first();
    }

    /**
     * Mettre à jour le vainqueur d'un match en fonction des scores de ses improvisations.
     */
    public function updateGameWinner($id) {
        try {
            $game = Game::findOrFail($id);
            $scoreTeam1 = Impro::where('game_id', $id)->where('vainqueur', $game->equipe_1)->count();
            $scoreTeam2 = Impro::where('game_id', $id)->where('vainqueur', $game->equipe_2)->count();

            $winner = null;
            if ($scoreTeam1 > $scoreTeam2) {
                $winner = $game->equipe_1;
            } elseif ($scoreTeam2 > $scoreTeam1) {
                $winner = $game->equipe_2;
            } else {
                $winner = '=';
            }

            $game->update(['vainqueur' => $winner]);

            return response()->json(['status' => 'success', 'winner' => $winner]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur est survenue lors de la mise à jour du vainqueur du jeu',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtenir les résultats d'un match : équipe gagnante et scores des deux équipes.
     */
    public function getGameResults($id) {
        $game = Game::findOrFail($id);
        $scoreTeam1 = Impro::where('game_id', $id)->where('vainqueur', $game->equipe_1)->count();
        $scoreTeam2 = Impro::where('game_id', $id)->where('vainqueur', $game->equipe_2)->count();
        return response()->json([
            'winner' => $game->vainqueur,
            'score_team_1' => $scoreTeam1,
            'score_team_2' => $scoreTeam2
        ]);
    }
}
