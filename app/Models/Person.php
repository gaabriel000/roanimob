<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Person extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'tax_id',
        'document_number',
        'birth_date'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
