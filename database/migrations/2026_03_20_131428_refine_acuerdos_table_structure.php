<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename 'ano' to 'ano_academico' and add 'ciclo'
        Schema::table('acuerdos', function (Blueprint $table) {
            if (Schema::hasColumn('acuerdos', 'ano')) {
                $table->renameColumn('ano', 'ano_academico');
            }
            if (!Schema::hasColumn('acuerdos', 'ciclo')) {
                $table->string('ciclo', 255)->nullable()->after('grupo');
            }
        });

        // Ensure 'ano_academico' can store strings like '2023/24'
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->string('ano_academico', 20)->change();
        });

        // 2. Drop 'avisado'
        Schema::table('acuerdos', function (Blueprint $table) {
            if (Schema::hasColumn('acuerdos', 'avisado')) {
                $table->dropColumn('avisado');
            }
        });

        // 3. Parameterize 'estado'
        Schema::table('acuerdos', function (Blueprint $table) {
            if (!Schema::hasColumn('acuerdos', 'estado_id')) {
                $table->foreignId('estado_id')->nullable()->after('estado_convenio')->constrained('estado_acuerdos')->onDelete('set null');
            }
        });

        // Migrate data
        $acuerdos = DB::table('acuerdos')->get();
        $estados = DB::table('estado_acuerdos')->pluck('id', 'nombre');

        foreach ($acuerdos as $acuerdo) {
            $estadoId = null;
            if ($acuerdo->estado_convenio === 'pendiente') {
                $estadoId = $estados['Pendiente'] ?? null;
            }
            elseif ($acuerdo->estado_convenio === 'hecho_pendiente_firma' || $acuerdo->estado_convenio === 'realizado') {
                $estadoId = $estados['Realizado'] ?? null;
            }
            elseif ($acuerdo->estado_convenio === 'firmado') {
                $estadoId = $estados['Firmado'] ?? null;
            }

            if ($estadoId) {
                DB::table('acuerdos')->where('id', $acuerdo->id)->update(['estado_id' => $estadoId]);
            }
        }

        // Drop old state column
        Schema::table('acuerdos', function (Blueprint $table) {
            if (Schema::hasColumn('acuerdos', 'estado_convenio')) {
                $table->dropColumn('estado_convenio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('acuerdos', function (Blueprint $table) {
            if (!Schema::hasColumn('acuerdos', 'estado_convenio')) {
                $table->enum('estado_convenio', ['pendiente', 'hecho_pendiente_firma', 'firmado'])->default('pendiente')->after('estado_id');
            }
            if (Schema::hasColumn('acuerdos', 'avisado')) {
            // Was already dropped, skip
            }
            else {
                $table->boolean('avisado')->default(false)->after('estado_id');
            }
        });

        // Reverse data migration if needed (complex, skipping for now as 'down' is rarely used in this context)

        Schema::table('acuerdos', function (Blueprint $table) {
            if (Schema::hasColumn('acuerdos', 'estado_id')) {
                $table->dropForeign(['estado_id']);
                $table->dropColumn('estado_id');
            }
            if (Schema::hasColumn('acuerdos', 'ciclo')) {
                $table->dropColumn('ciclo');
            }
            if (Schema::hasColumn('acuerdos', 'ano_academico')) {
                $table->renameColumn('ano_academico', 'ano');
            }
        });
    }
};
