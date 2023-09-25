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
        'fechaTexto',
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
        'facturaA',

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
    public function status(){
        return $this->hasMany(Statu::class);
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
    protected $appends = ['precioTotal','deuda','sena'];
    public function getPrecioTotalAttribute(){
        $total = round( $this->precioProducto + $this->precioDiseno + $this->precioEspecificaciones + $this->precioEnvio,2);
//        $iva = round( $total * ($this->iva/100),2);
//        if (this.pedido.facturaA === 'Factura ninguna') {
//            return 0
//      } else if (this.pedido.facturaA === 'Factura pedido') {
//            return Math.round(this.precioTotal * parseFloat(this.pedido.iva) / 100 * 100) / 100
//      } else if (this.pedido.facturaA === 'Factura seña') {
//            return Math.round(this.pedido.pago * parseFloat(this.pedido.iva) / 100 * 100) / 100
//      }
        $iva = 0;
        if ($this->facturaA === 'Factura ninguna') {
            $iva = 0;
        } else if ($this->facturaA === 'Factura pedido') {
            $iva = round($total * ($this->iva/100),2);
        } else if ($this->facturaA === 'Factura seña') {
            $iva = round($this->pago * ($this->iva/100),2);
        }
        return $total+$iva;
    }
    public function getDeudaAttribute(){
        $monto = $this->precioTotal - $this->pago - Pago::where('pedido_id',$this->id)->get()->sum('monto');
        return round( $monto,2);
    }
    public function getSenaAttribute(){
        $pagos = Pago::where('pedido_id',$this->id)->get()->sum('monto');
        return round( $this->pago+$pagos,2);
    }
}
