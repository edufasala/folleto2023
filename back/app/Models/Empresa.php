<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Empresa extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'nombre',
        'contacto',
        'vendedor',
        'credibilidad',
    ];
    protected $appends = ['codigo'];
    public function pedidos()
    {
        return $this->hasMany(Pedido::class)->with('user')->orderByRaw("
    CASE
        WHEN estadoPedido = 'Activo' THEN 1
        WHEN estadoPedido = 'Atrasado' THEN 2
        WHEN estadoPedido = 'StandBy' THEN 3
        WHEN estadoPedido = 'Deudor' THEN 4
        WHEN estadoPedido = 'Cancelado' THEN 5
        WHEN estadoPedido = 'Terminado' THEN 6
        ELSE 7
    END
");
    }
    public function getCodigoAttribute()
    {
        return '#'.str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
    public function direccion()
    {
        return $this->hasMany(Direccion::class);
    }
    public function facturacion()
    {
        return $this->hasMany(Facturacion::class);
    }
    public function sucursals()
    {
        return $this->hasMany(Sucursal::class);
    }
    public function person()
    {
        return $this->hasMany(Person::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('created_at','desc');
    }
    protected $hidden = ['updated_at'];
}
