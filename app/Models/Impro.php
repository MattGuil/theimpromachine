<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impro extends Model
{
    use HasFactory;

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

    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
}
