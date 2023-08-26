<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'contacto',
        'vendedor',
    ];
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
}
