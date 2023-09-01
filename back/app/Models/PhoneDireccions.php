<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PhoneDireccions extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'phone',
        'direccion_id'
    ];
    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
