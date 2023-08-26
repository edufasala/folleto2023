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
    protected $appends = ['codigo'];
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
    protected $hidden = ['created_at'];
}
