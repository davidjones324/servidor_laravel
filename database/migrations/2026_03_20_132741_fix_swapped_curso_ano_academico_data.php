<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Corrige registros donde curso contiene el año académico (ej: "2025/2026")
     * y ano_academico contiene el número de curso (ej: "2").
     * Intercambia los valores y normaliza curso a formato "Xº".
     */
    public function up(): void
    {
        $acuerdos = DB::table('acuerdos')
            ->where('curso', 'LIKE', '%/%')
            ->get();

        foreach ($acuerdos as $acuerdo) {
            $realAnoAcademico = $acuerdo->curso;
            $rawCurso = trim($acuerdo->ano_academico ?? '');

            $normalizedCurso = $rawCurso;
            if (is_numeric($rawCurso)) {
                $normalizedCurso = $rawCurso . 'º';
            }

            DB::table('acuerdos')
                ->where('id', $acuerdo->id)
                ->update([
                'ano_academico' => $realAnoAcademico,
                'curso' => $normalizedCurso,
            ]);
        }
    }

    public function down(): void
    {
    // No reversible de forma segura
    }
};
