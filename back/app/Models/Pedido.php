<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Pedido extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'codigo',
        'producto',
        'medida',
        'cantidad',
        'esp',
        'gr',
        'lados',
        'diseno',
        'descripcion',
        'estado',
        'estadoPedido',
        'diasCompra',
        'fecha',
        'fechaEntrega',
        'fechaEspecial',
        'precioProducto',
        'precioDiseno',

        'especificaciones',
        'terminacion',
        'envio',
        'precioEspecificaciones',
        'precioEnvio',

        'pago',
        'metodoPago',
        'comentarioPago',
        'iva',
        'seFacturo',

//        'precioTotal',
        'user_id',
        'empresa_id',
        'sucursal_id',
        'facturacion_id',
        'direccion_id',
        'persona_id',
        'phone_id',
        'email_id',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
    public function pagos(){
        return $this->hasMany(Pago::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
    public function facturacion(){
        return $this->belongsTo(Facturacion::class);
    }
    public function direccion(){
        return $this->belongsTo(Direccion::class);
    }
    public function person(){
        return $this->belongsTo(Person::class, 'persona_id');
    }
    public function phone(){
        return $this->belongsTo(Phone::class);
    }
    public function email(){
        return $this->belongsTo(Email::class);
    }
    protected $appends = ['precioTotal','deuda'];
    public function getPrecioTotalAttribute(){
        return round( $this->precioProducto + $this->precioDiseno + $this->precioEspecificaciones + $this->precioEnvio,2);
    }
    public function getDeudaAttribute(){
        return round( $this->precioTotal - $this->pago,2);
    }
}
