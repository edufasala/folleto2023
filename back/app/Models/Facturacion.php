<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facturacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'cuit',
        'condicional',
        'razonSocial',
        'comentario',
        'empresa_id'
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
