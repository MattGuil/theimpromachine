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
            $table->integer('position')->default(1000);
            $table->enum('type', ['Mixte', 'Comparée']);
            $table->integer('nb_joueurs'); // -1 => nombre de joueurs illimité
            $table->integer('duree');
            $table->foreignId('categorie_id')->index();
            $table->string('theme');
            $table->string('vainqueur')->nullable();
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
