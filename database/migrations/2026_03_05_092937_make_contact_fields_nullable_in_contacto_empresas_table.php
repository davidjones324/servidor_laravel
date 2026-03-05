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
        Schema::table('contacto_empresas', function (Blueprint $table) {
            $table->string('correo', 150)->nullable()->change();
            $table->string('apellidos', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacto_empresas', function (Blueprint $table) {
            $table->string('correo', 150)->nullable(false)->change();
            $table->string('apellidos', 150)->nullable(false)->change();
        });
    }
};
