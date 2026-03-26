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
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('domicilio', 255)->nullable()->after('direccion');
            $table->string('localidad', 150)->nullable()->after('domicilio');
            $table->string('codigo_postal', 10)->nullable()->after('localidad');
            $table->string('provincia', 100)->nullable()->after('codigo_postal');
            $table->string('numero_ss', 20)->nullable()->after('provincia');

        // Adjust estudios_anteriores if needed (already exists as text, 
        // but user mentioned varchar(200) or textarea, text is better for textarea)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn(['domicilio', 'localidad', 'codigo_postal', 'provincia', 'numero_ss']);
        });
    }
};
