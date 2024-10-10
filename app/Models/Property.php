<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // Define a tabela associada, se for diferente do padrão (plural do nome do modelo)
    protected $table = 'properties';

    // Os atributos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'title',
        'description',
        'status',
        'address_id'
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
