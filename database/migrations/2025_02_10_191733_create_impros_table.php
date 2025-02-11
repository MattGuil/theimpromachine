<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('impros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->index();
            $table->enum('type', ['Mixte', 'Comparée']);
            $table->integer('nb_joueur'); // -1 => nombre de joueurs illimité
            $table->integer('duree');
            $table->foreignId('categorie_id')->index();
            $table->string('theme');
            $table->enum('statut', ['Créée', 'En cours', 'Jouée'])->default('Créée');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impros');
    }
};
