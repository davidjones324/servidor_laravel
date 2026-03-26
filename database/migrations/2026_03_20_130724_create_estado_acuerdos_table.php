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
        Schema::create('estado_acuerdos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Insert initial values
        DB::table('estado_acuerdos')->insert([
            ['nombre' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Realizado', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Firmado', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_acuerdos');
    }
};
