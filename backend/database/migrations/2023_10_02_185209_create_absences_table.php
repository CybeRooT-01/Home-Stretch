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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('session_id');
            $table->foreign('etudiant_id')->references('id')->on('etudiants');
            $table->foreign('session_id')->references('id')->on('session_cours');
            $table->date('date');
            $table->boolean('justifiee')->default(false);
            $table->string('motif')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
