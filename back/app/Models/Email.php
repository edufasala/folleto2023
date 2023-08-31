<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'email',
        'status',
        'person_id'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
