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
        // First, convert existing data to boolean-like values (0 or 1)
        // null or empty string -> 0
        // anything else -> 1
        DB::table('alumnos')->whereNull('seguro_escolar')->orWhere('seguro_escolar', '')->update(['seguro_escolar' => '0']);
        DB::table('alumnos')->where('seguro_escolar', '!=', '0')->update(['seguro_escolar' => '1']);

        Schema::table('alumnos', function (Blueprint $table) {
            $table->boolean('seguro_escolar')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('seguro_escolar')->nullable()->change();
        });
    }
};
