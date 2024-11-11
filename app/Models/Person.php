<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasUuids;

    protected $table = 'persons';

    protected $fillable = [
        'id',
        'type',
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

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
