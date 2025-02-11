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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('equipe_1');
            $table->string('equipe_2');
            $table->integer('equipe_1_score')->nullable();
            $table->integer('equipe_2_score')->nullable();
            $table->enum('statut', ['Créée', 'En cours', 'Terminée'])->default('Créée');
            $table->string('vainqueur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
