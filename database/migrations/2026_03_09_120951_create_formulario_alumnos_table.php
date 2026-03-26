<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up()
    {
        if (Schema::hasTable('formulario_alumnos')) {
            return;
        }

        Schema::create('formulario_alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('desplazamiento')->nullable();
            $table->text('observaciones_desplazamiento')->nullable();

            $table->string('ciclo_distinto')->nullable();
            $table->string('ciclo_distinto_otro')->nullable();

            $table->boolean('ha_hecho_fct_antes')->nullable();
            $table->string('empresa_fct_anterior')->nullable();
            $table->string('poblacion_fct_anterior')->nullable();

            $table->string('interes_practicas')->nullable();
            $table->string('interes_seguir_estudiando')->nullable();
            $table->string('interes_quedarse_empresa')->nullable();
            $table->string('interes_compartir_empresa')->nullable();
            $table->string('miedo_practicas')->nullable();
            $table->string('actitud_practicas')->nullable();

            $table->text('empresa_destino_practicas')->nullable();

            $table->string('tiene_empresa_pensada')->nullable();
            $table->string('empresa_pensada_nombre')->nullable();
            $table->string('empresa_pensada_localidad')->nullable();
            $table->string('empresa_pensada_telefono')->nullable();
            $table->string('empresa_pensada_contacto')->nullable();

            $table->text('otras_empresas_interes')->nullable();
            $table->text('observaciones_empresas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulario_alumnos');
    }
};
