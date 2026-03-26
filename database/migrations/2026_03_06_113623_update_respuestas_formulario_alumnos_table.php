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
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            $table->string('desplazamiento', 255)->nullable();
            $table->text('observaciones_desplazamiento')->nullable();
            $table->string('ciclo_distinto', 255)->nullable();
            $table->boolean('ha_hecho_fct_antes')->default(false);
            $table->string('empresa_fct_anterior', 255)->nullable();
            $table->string('poblacion_fct_anterior', 255)->nullable();
            $table->text('empresa_destino_practicas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            $table->dropColumn([
                'desplazamiento',
                'observaciones_desplazamiento',
                'ciclo_distinto',
                'ha_hecho_fct_antes',
                'empresa_fct_anterior',
                'poblacion_fct_anterior',
                'empresa_destino_practicas'
            ]);
        });
    }
};
