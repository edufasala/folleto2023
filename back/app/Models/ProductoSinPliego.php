<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoSinPliego extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'productoServicio',
        'imprime',
        'nombre',
        'tipoMaterial',
        'gr',
        'tamano',
        'fracciona',
        'porLado',
        'desde',
        'hasta',
        'precio',
        'comentario',
    ];
}
