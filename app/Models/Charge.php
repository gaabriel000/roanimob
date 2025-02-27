<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = [
        'amount',
        'installments',
        'contract_id'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
