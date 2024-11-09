<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasUuids;

    protected $table = 'addresses';

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
