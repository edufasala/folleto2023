<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'status',
        'email',
        'person_id'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
