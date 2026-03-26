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
        // 1. Añadir campo is_representante_legal a contacto_empresas
        if (!Schema::hasColumn('contacto_empresas', 'is_representante_legal')) {
            Schema::table('contacto_empresas', function (Blueprint $table) {
                $table->boolean('is_representante_legal')->default(false)->after('es_tutor_laboral_fct');
            });
        }

        // 2. Migrar datos de responsables a contacto_empresas
        if (Schema::hasTable('responsables')) {
            $responsables = DB::table('responsables')->get();
            $mapping = [];

            foreach ($responsables as $r) {
                // Saltar si no hay empresa_id
                if (empty($r->empresa_id))
                    continue;

                // Verificar si el contacto ya existe por DNI o Email en la misma empresa
                $existing = DB::table('contacto_empresas')
                    ->where('empresa_id', $r->empresa_id)
                    ->where(function ($q) use ($r) {
                    if ($r->dni)
                        $q->where('dni', $r->dni);
                    if ($r->email)
                        $q->orWhere('correo', $r->email);
                })->first();

                if ($existing) {
                    DB::table('contacto_empresas')->where('id', $existing->id)->update(['is_representante_legal' => true]);
                    $mapping[$r->id] = $existing->id;
                }
                else {
                    $newId = DB::table('contacto_empresas')->insertGetId([
                        'empresa_id' => $r->empresa_id,
                        'dni' => $r->dni,
                        'nombre' => $r->nombre,
                        'apellidos' => $r->apellidos,
                        'correo' => $r->email,
                        'telefono' => $r->telefono,
                        'puesto' => $r->cargo,
                        'is_representante_legal' => true,
                        'es_tutor_laboral_fct' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $mapping[$r->id] = $newId;
                }
            }

            // 3. Actualizar tabla acuerdos
            // Renombrar columna si aún existe la vieja
            if (Schema::hasColumn('acuerdos', 'responsable_id')) {
                Schema::table('acuerdos', function (Blueprint $table) {
                    try {
                        $table->dropForeign(['responsable_id']);
                    }
                    catch (\Exception $e) { /* Ya no existe */
                    }
                });

                // Actualizar los IDs en la tabla acuerdos antes de renombrar
                foreach ($mapping as $oldId => $newId) {
                    DB::table('acuerdos')->where('responsable_id', $oldId)->update(['responsable_id' => $newId]);
                }

                Schema::table('acuerdos', function (Blueprint $table) {
                    // Hacer la columna nullable para evitar errores con huérfanos
                    $table->unsignedBigInteger('responsable_id')->nullable()->change();
                    $table->renameColumn('responsable_id', 'representante_id');
                });
            }
            else if (Schema::hasColumn('acuerdos', 'representante_id')) {
                // Si ya existe representante_id, asegurar que sea nullable
                Schema::table('acuerdos', function (Blueprint $table) {
                    $table->unsignedBigInteger('representante_id')->nullable()->change();
                });

                foreach ($mapping as $oldId => $newId) {
                    DB::table('acuerdos')->where('representante_id', $oldId)->update(['representante_id' => $newId]);
                }
            }

            // Limpiar IDs que no existan en contacto_empresas para evitar fallos de FK
            $invalidAcuerdos = DB::table('acuerdos')
                ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('contacto_empresas')
                    ->whereRaw('contacto_empresas.id = acuerdos.representante_id');
            })
                ->update(['representante_id' => null]);

            // Asegurar FK en la nueva/existente columna representante_id
            Schema::table('acuerdos', function (Blueprint $table) {
                try {
                    $table->foreign('representante_id')->references('id')->on('contacto_empresas')->onDelete('set null');
                }
                catch (\Exception $e) { /* Ya existe */
                }
            });

            // 4. Eliminar tabla responsables
            Schema::dropIfExists('responsables');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Inversa compleja, recreamos la tabla y devolvvemos la columna
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('dni')->nullable();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('cargo')->nullable();
            $table->timestamps();
        });

        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropForeign(['representante_id']);
            $table->renameColumn('representante_id', 'responsable_id');
        });

        Schema::table('acuerdos', function (Blueprint $table) {
            $table->foreign('responsable_id')->references('id')->on('responsables')->onDelete('cascade');
        });

        Schema::table('contacto_empresas', function (Blueprint $table) {
            $table->dropColumn('is_representante_legal');
        });
    }
};
