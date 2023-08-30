<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direccions';
    protected $fillable = [
        'direccion',
        'codigoPostal',
        'localidad',
        'empresa_id'
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function phoneDireccions()
    {
        return $this->hasMany(PhoneDireccions::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
