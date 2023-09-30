<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoDiseno extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'diseno',
        'tamano',
        'lado',
        'precio',
        'comentario',
    ];
}
