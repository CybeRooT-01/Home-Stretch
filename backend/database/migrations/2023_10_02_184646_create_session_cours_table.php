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
        Schema::create('session_cours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cours_id');
            $table->unsignedBigInteger('salle_id');
            $table->foreign('cours_id')->references('id')->on('cours')->onDelete('cascade');
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->boolean('validee')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_cours');
    }
};
