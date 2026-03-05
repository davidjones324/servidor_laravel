<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('respuestas_formulario_alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');

            // Tabla de intereses — valores: mucho, normal, poco, muy_poco
            $table->enum('interes_practicas', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();
            $table->enum('interes_seguir_estudiando', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();
            $table->enum('interes_quedarse_empresa', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();
            $table->enum('interes_compartir_empresa', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();
            $table->enum('miedo_practicas', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();
            $table->enum('actitud_practicas', ['mucho', 'normal', 'poco', 'muy_poco'])->nullable();

            // Empresa pensada
            $table->enum('tiene_empresa_pensada', ['si', 'no', 'si_sin_contacto'])->nullable();
            $table->string('empresa_pensada_nombre', 255)->nullable();
            $table->string('empresa_pensada_localidad', 150)->nullable();
            $table->string('empresa_pensada_telefono', 20)->nullable();
            $table->string('empresa_pensada_contacto', 150)->nullable();

            // Otras empresas y observaciones
            $table->text('otras_empresas_interes')->nullable();
            $table->text('observaciones_empresas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas_formulario_alumnos');
    }
};
