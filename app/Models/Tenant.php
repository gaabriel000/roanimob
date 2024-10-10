<?php

namespace App\Models;

class Tenant extends Person
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
