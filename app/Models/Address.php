<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'id',
        'street',
        'number',
        'is_no_number',
        'complement',
        'neighborhood',
        'postal_code',
        'city',
        'state',
        'country'
    ];
}
