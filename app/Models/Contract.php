<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'rent_amount',
        'guarantee_type',
        'payment_date',
        'payment_date_type',
        'status',
        'owner_id',
        'tenant_id',
        'property_id',
        'parent_contract_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
