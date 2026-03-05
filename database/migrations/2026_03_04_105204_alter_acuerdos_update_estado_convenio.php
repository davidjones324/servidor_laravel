<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        // Actualizar el enum de estado_convenio y añadir campo avisado
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE acuerdos MODIFY COLUMN estado_convenio ENUM('pendiente','hecho_pendiente_firma','firmado') DEFAULT 'pendiente'"
        );

        Schema::table('acuerdos', function (Blueprint $table) {
            $table->boolean('avisado')->default(false)->after('estado_convenio');
        });
    }

    public function down(): void
    {
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropColumn('avisado');
        });

        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE acuerdos MODIFY COLUMN estado_convenio ENUM('pendiente','realizado','firmado') DEFAULT 'pendiente'"
        );
    }
};
