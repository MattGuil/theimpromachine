<?php

namespace App\Http\Controllers;

use App\Models\Categorie;

class CategorieController
{
    /**
     * Obtenir toutes les catégories.
     */
    public function getCategories() {
        return Categorie::all();
    }

    /**
     * Obtenir toutes les catégories groupées par type.
     */
    public function getCategoriesByType() {
        return Categorie::all()->groupBy('type');
    }
}
