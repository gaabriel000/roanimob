<?php

namespace App\Models;

class Owner extends Person
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mergeFillable(['property_id']);
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
