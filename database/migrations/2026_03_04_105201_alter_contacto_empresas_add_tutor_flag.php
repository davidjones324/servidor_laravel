<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('contacto_empresas', function (Blueprint $table) {
            $table->boolean('es_tutor_laboral_fct')->default(false)->after('puesto');
        });
    }

    public function down(): void
    {
        Schema::table('contacto_empresas', function (Blueprint $table) {
            $table->dropColumn('es_tutor_laboral_fct');
        });
    }
};
