<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsables';

    protected $fillable = [
        'dni', 'nombre', 'apellidos', 'email', 'telefono', 'cargo'
    ];

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class , 'responsable_id');
    }
}
