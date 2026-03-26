<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioAlumno extends Model
{
    protected $table = 'formulario_alumnos';

    protected $fillable = [
        'user_id',
        'desplazamiento',
        'observaciones_desplazamiento',
        'ciclo_distinto',
        'ciclo_distinto_otro',
        'ha_hecho_fct_antes',
        'empresa_fct_anterior',
        'poblacion_fct_anterior',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
