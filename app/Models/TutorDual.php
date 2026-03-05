<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorDual extends Model
{
    use HasFactory;
    protected $fillable = [
        'dni', 'nombre', 'apellidos', 'email', 'telefono', 'ciclo'
    ];

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }
}
