<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Person extends Model
{
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'tax_id',
        'tax_type',
        'document_number',
        'birth_date',
        'address_id'
    ];
}
