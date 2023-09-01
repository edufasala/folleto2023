<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Facturacion extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
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
