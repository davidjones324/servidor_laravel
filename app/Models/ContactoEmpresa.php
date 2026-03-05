<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoEmpresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id', 'dni', 'nombre', 'apellidos', 'correo', 'telefono',
        'puesto', 'es_tutor_laboral_fct',
    ];

    protected $casts = [
        'es_tutor_laboral_fct' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
