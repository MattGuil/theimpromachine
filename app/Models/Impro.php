<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impro extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'game_id',
        'position',
        'type',
        'nb_joueurs',
        'duree',
        'categorie_id',
        'theme',
        'vainqueur'
    ];

    /**
     * Obtenir la catégorie à laquelle appartient cette improvisation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
}
