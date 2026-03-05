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
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('tutor_dual_id')->constrained('tutor_duals')->onDelete('cascade');
            $table->foreignId('coordinador_id')->constrained('coordinadors')->onDelete('cascade');
            $table->string('localidad', 150);
            $table->string('nombre_acuerdo', 255);
            $table->enum('estado_convenio', ['pendiente', 'realizado', 'firmado'])->default('pendiente');
            $table->text('horario')->nullable();
            $table->integer('horas_totales');
            $table->string('grupo', 20);
            $table->string('curso', 20);
            $table->year('ano');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acuerdos');
    }
};
