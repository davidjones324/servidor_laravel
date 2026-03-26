<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            if (!Schema::hasColumn('respuestas_formulario_alumnos', 'segunda_residencia')) {
                $table->text('segunda_residencia')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            $table->dropColumn(['segunda_residencia']);
        });
    }
};
