<?php

namespace App\Validators;

use App\Rules\EnumKey;
use App\Enums\State;
use App\Enums\Country;

const REQUIRED_WITH = 'required_with:address';

class AddressValidator extends BaseValidator
{
    public function rules(): array
    {
        return [
            'street' => 'required|max:50',
            'number' => 'nullable|numeric',
            'complement' => 'nullable|max:255',
            'neighborhood' => 'max:255',
            'postal_code' => 'nullable|numeric',
            'city' => 'nullable|max:50',
            'state' => ['required', new EnumKey(State::class)],
            'country' => ['required', new EnumKey(Country::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'street.required' => 'O campo street é obrigatório.',
            'street.max' => 'O campo street deve ter no máximo 50 caracteres.',
            'number.number' => 'O campo number deve conter apenas números.',
            'complement.max' => 'O campo complement deve ter no máximo 255 caracteres.',
            'neighborhood.alpha' => 'O campo neighborhood deve conter apenas letras.',
            'neighborhood.max' => 'O campo neighborhood deve ter no máximo 255 caracteres.',
            'postal_code.alpha' => 'O campo postalCode deve conter apenas letras.',
            'postal_code.max' => 'O campo postalCode deve ter no máximo 50 caracteres.',
            'city.max' => 'O campo city deve ter no máximo 50 caracteres.',
            'state.required' => 'O campo state é obrigatório.',
            'country.required' => 'O campo country é obrigatório.',
        ];
    }
}
