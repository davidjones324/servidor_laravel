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
        Schema::create('tutor_duals', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 20);
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('email', 150);
            $table->string('telefono', 20);
            $table->enum('ciclo', ['ASIR', 'SMR', 'DAM']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_duals');
    }
};
