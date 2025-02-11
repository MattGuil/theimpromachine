<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impro extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'type',
        'nb_joueur',
        'duree',
        'categorie_id',
        'theme',
        'statut'
    ];
}
