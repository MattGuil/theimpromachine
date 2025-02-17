<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'arbitre',
        'equipe_1',
        'equipe_2',
        'equipe_1_score',
        'equipe_2_score',
        'vainqueur'
    ];
}
