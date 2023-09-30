<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Pago extends Model implements Auditable
{
    use HasFactory,SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $fillable = [
        'fecha',
        'hora',
        'monto',
        'facturado',
        'tipo',
        'metodoPago',
        'comentario',
        'user_id',
        'pedido_id',
    ];
    protected $appends = ['dni','nombre'];
    public function getDniAttribute()
    {
        $pedido = Pedido::find($this->pedido_id);
        $persona = Person::find($pedido->persona_id);
        if($persona){
            return $persona->dni;
        }else{
            return '';
        }
    }
    public function getNombreAttribute()
    {
        $pedido = Pedido::find($this->pedido_id);
        $persona = Person::find($pedido->persona_id);
        if ($persona) {
            return $persona->nombre;
        } else {
            return '';
        }
    }
    public function facturacion()
    {
        return $this->belongsTo(Facturacion::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $hidden = ['updated_at','deleted_at','created_at'];
}
