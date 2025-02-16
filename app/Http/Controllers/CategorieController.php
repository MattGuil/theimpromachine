<?php

namespace App\Http\Controllers;

use App\Models\Categorie;

class CategorieController
{
    public function getCategories() {
        return Categorie::all();
    }

    public function getCategoriesByType() {
        return Categorie::all()->groupBy('type');
    }
}
