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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->date('fecha_nacimiento');
            $table->string('curso', 20);
            $table->string('grupo', 20);
            $table->string('direccion', 255);
            $table->string('telefono', 20);
            $table->string('email', 150);
            $table->boolean('carnet_conducir')->default(false);
            $table->boolean('coche_propio')->default(false);
            $table->text('estudios_anteriores')->nullable();
            $table->string('practicas_pasadas', 255)->nullable();
            $table->boolean('apto_ffoe')->default(false);
            $table->enum('motivo_exclusion', ['no_prl', 'matricula_incompleta', 'otros'])->nullable();
            $table->string('residencia', 150)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
