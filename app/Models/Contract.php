<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contract extends Model
{
    use HasUuids;

    protected $table = 'contracts';

    protected $fillable = [
        'start_date',
        'end_date',
        'rent_amount',
        'guarantee_type',
        'due_date',
        'payment_date_type',
        'status',
        'owner_id',
        'tenant_id',
        'property_id',
        'parent_contract_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'owner_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'tenant_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function parentContract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'parent_contract_id');
    }
}
