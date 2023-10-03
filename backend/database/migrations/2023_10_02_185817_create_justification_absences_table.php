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
        Schema::create('justification_absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_id');
            $table->unsignedBigInteger('professeur_id');
            $table->text('motif');
            $table->boolean('validee')->default(false);
            $table->foreign('absence_id')->references('id')->on('absences')->onDelete('cascade');
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('justification_absences');
    }
};
