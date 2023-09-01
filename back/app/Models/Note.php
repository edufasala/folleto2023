<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Note extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'body',
        'date',
        'color',
        'user_id',
        'empresa_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
