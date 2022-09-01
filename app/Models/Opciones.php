<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pregunta',
        'nombre_opcion'
      ];
}
