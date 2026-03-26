<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            $columnsToAdd = [
                'desplazamiento' => ['type' => 'string', 'nullable' => true],
                'observaciones_desplazamiento' => ['type' => 'text', 'nullable' => true],
                'ciclo_distinto' => ['type' => 'string', 'nullable' => true],
                'ciclo_distinto_otro' => ['type' => 'string', 'nullable' => true],
                'ha_hecho_fct_antes' => ['type' => 'boolean', 'nullable' => true],
                'interes_practicas' => ['type' => 'string', 'nullable' => true],
                'interes_seguir_estudiando' => ['type' => 'string', 'nullable' => true],
                'interes_quedarse_empresa' => ['type' => 'string', 'nullable' => true],
                'interes_compartir_empresa' => ['type' => 'string', 'nullable' => true],
                'miedo_practicas' => ['type' => 'string', 'nullable' => true],
                'actitud_practicas' => ['type' => 'string', 'nullable' => true],
                'empresa_destino_practicas' => ['type' => 'text', 'nullable' => true],
                'tiene_empresa_pensada' => ['type' => 'string', 'nullable' => true],
                'empresa_pensada_nombre' => ['type' => 'string', 'nullable' => true],
                'empresa_pensada_localidad' => ['type' => 'string', 'nullable' => true],
                'empresa_pensada_telefono' => ['type' => 'string', 'nullable' => true],
                'empresa_pensada_contacto' => ['type' => 'string', 'nullable' => true],
                'otras_empresas_interes' => ['type' => 'text', 'nullable' => true],
                'observaciones_empresas' => ['type' => 'text', 'nullable' => true],
            ];

            foreach ($columnsToAdd as $columnName => $config) {
                if (!Schema::hasColumn('respuestas_formulario_alumnos', $columnName)) {
                    if ($config['type'] === 'string') {
                        $table->string($columnName)->nullable();
                    }
                    elseif ($config['type'] === 'text') {
                        $table->text($columnName)->nullable();
                    }
                    elseif ($config['type'] === 'boolean') {
                        $table->boolean($columnName)->nullable();
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('respuestas_formulario_alumnos', function (Blueprint $table) {
            $columns = [
                'desplazamiento', 'observaciones_desplazamiento',
                'ciclo_distinto', 'ciclo_distinto_otro',
                'ha_hecho_fct_antes',
                'interes_practicas', 'interes_seguir_estudiando',
                'interes_quedarse_empresa', 'interes_compartir_empresa',
                'miedo_practicas', 'actitud_practicas',
                'empresa_destino_practicas',
                'tiene_empresa_pensada', 'empresa_pensada_nombre',
                'empresa_pensada_localidad', 'empresa_pensada_telefono',
                'empresa_pensada_contacto',
                'otras_empresas_interes', 'observaciones_empresas',
            ];

            $existingColumns = Schema::getColumnListing('respuestas_formulario_alumnos');
            $toDrop = array_intersect($columns, $existingColumns);

            if (!empty($toDrop)) {
                $table->dropColumn($toDrop);
            }
        });
    }
};
