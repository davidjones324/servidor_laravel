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
        Schema::table('tutor_duals', function (Blueprint $table) {
            $table->renameColumn('ciclo', 'ciclos');
            $table->text('cursos')->nullable();
        });

        Schema::table('tutor_duals', function (Blueprint $table) {
            $table->text('ciclos')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutor_duals', function (Blueprint $table) {
            $table->string('ciclos')->change();
            $table->renameColumn('ciclos', 'ciclo');
            $table->dropColumn('cursos');
        });
    }
};
