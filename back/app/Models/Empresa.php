<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;
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
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    protected $hidden = ['updated_at'];
}
