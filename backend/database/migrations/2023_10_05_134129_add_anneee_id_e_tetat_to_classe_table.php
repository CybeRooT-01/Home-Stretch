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
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('annee_id')->nullable()->after('id');
            $table->foreign('annee_id')->references('id')->on('annee_scolaires')->onDelete('cascade');
            $table->boolean('etat')->default(true)->after('niveau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['annee_id']);
            $table->dropColumn('annee_id');
            $table->dropColumn('etat');
        });
    }
};
