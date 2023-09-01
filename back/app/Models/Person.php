<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Person extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'nombre',
        'cargo',
        'dni',
        'empresa_id'
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function phone(){
        return $this->hasMany(Phone::class);
    }
    public function email(){
        return $this->hasMany(Email::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
