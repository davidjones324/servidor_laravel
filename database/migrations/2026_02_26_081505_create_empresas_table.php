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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social', 255);
            $table->string('cif', 20);
            $table->string('direccion', 255);
            $table->string('poblacion', 150);
            $table->string('email', 150);
            $table->text('observaciones')->nullable();
            $table->string('campo_laboral', 150);
            $table->json('ciclos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
