<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'due_date',
        'paid_amount',
        'status',
        'charge_id'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
