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
        // 1. Rename coordinadors table to responsables
        Schema::rename('coordinadors', 'responsables');

        // 2. Add cargo to responsables
        Schema::table('responsables', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('apellidos');
        });

        // 3. Rename coordinador_id to responsable_id in acuerdos
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropForeign(['coordinador_id']);
            $table->renameColumn('coordinador_id', 'responsable_id');

            // Re-add foreign key
            $table->foreign('responsable_id')->references('id')->on('responsables')->onDelete('cascade');

            // 4. Add contacto_empresa_id to acuerdos
            $table->foreignId('contacto_empresa_id')->nullable()->after('empresa_id')->constrained('contacto_empresas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropForeign(['contacto_empresa_id']);
            $table->dropColumn('contacto_empresa_id');

            $table->dropForeign(['responsable_id']);
            $table->renameColumn('responsable_id', 'coordinador_id');
            $table->foreign('coordinador_id')->references('id')->on('coordinadors')->onDelete('cascade');
        });

        Schema::table('responsables', function (Blueprint $table) {
            $table->dropColumn('cargo');
        });

        Schema::rename('responsables', 'coordinadors');
    }
};
