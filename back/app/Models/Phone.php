<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'person_id'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
