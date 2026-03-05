<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Transporte: reemplaza la lógica de carnet+coche con un enum más claro
            $table->enum('transporte', [
                'carnet_y_coche',
                'transporte_publico',
                'sin_desplazamiento',
            ])->nullable()->after('coche_propio');

            // Ciclo formativo y año (separados del campo "curso" genérico existente)
            $table->string('ciclo', 20)->nullable()->after('grupo');
            $table->tinyInteger('anio_ciclo')->nullable()->after('ciclo');

            // Observaciones generales del alumno
            $table->text('observaciones')->nullable()->after('residencia');

            // Refactorizar prácticas pasadas: separar en campos más específicos
            $table->boolean('ha_realizado_fct_anterior')->default(false)->after('practicas_pasadas');
            $table->string('empresa_fct_anterior', 255)->nullable()->after('ha_realizado_fct_anterior');
            $table->string('localidad_fct_anterior', 150)->nullable()->after('empresa_fct_anterior');
        });

        // Cambiar motivo_exclusion de enum a string para acomodar valores dinámicos
        // MySQL no permite ALTER COLUMN de enum a string directamente con Blueprint,
        // usamos raw SQL
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE alumnos MODIFY COLUMN motivo_exclusion VARCHAR(100) NULL"
        );
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn([
                'transporte',
                'ciclo',
                'anio_ciclo',
                'observaciones',
                'ha_realizado_fct_anterior',
                'empresa_fct_anterior',
                'localidad_fct_anterior',
            ]);
        });

        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE alumnos MODIFY COLUMN motivo_exclusion ENUM('no_prl','matricula_incompleta','otros') NULL"
        );
    }
};
