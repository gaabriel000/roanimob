<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalCharge extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'installments',
        'contract_id'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
