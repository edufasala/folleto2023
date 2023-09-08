<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Statu extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'fecha',
        'hora',
        'realizado',
        'nota',
        'user_id',
        'pedido_id',
    ];
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
