<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoTerminacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nombre',
        'gr',
        'tamanoMaximo',
        'tamanoMinimo',
        'desde',
        'precio',
        'primeros1000',
        'siguientes1000',
        'comentario',
    ];
}
