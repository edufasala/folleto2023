<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneDireccions extends Model
{
    use HasFactory;
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
