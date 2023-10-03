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
        Schema::create('demande_annulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professeur_id');
            $table->unsignedBigInteger('session_cours_id');
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade');
            $table->foreign('session_cours_id')->references('id')->on('session_cours')->onDelete('cascade');
            $table->text('motif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_annulations');
    }
};
