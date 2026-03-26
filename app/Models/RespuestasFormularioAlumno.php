<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestasFormularioAlumno extends Model
{
    protected $table = 'respuestas_formulario_alumnos';

    protected $fillable = [
        'alumno_id', // ← CAMBIAR ESTO
        'desplazamiento',
        'observaciones_desplazamiento',
        'ciclo_distinto',
        'ha_hecho_fct_antes',
        'interes_practicas',
        'interes_seguir_estudiando',
        'interes_quedarse_empresa',
        'interes_compartir_empresa',
        'miedo_practicas',
        'actitud_practicas',
        'empresa_destino_practicas',
        'tiene_empresa_pensada',
        'empresa_pensada_nombre',
        'empresa_pensada_localidad',
        'empresa_pensada_telefono',
        'empresa_pensada_contacto',
        'otras_empresas_interes',
        'observaciones_empresas',
    ];
}
