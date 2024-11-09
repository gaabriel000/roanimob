<?php

namespace App\Validators;

use App\Rules\EnumKey;
use App\Enums\State;
use App\Enums\Country;

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
            'number.required_if' => 'O campo number é obrigatório quando o campo is_no_number for false.',
            'number.number' => 'O campo number deve conter apenas números.',
            'is_no_number.required' => 'O campo is_no_number é obrigatório.',
            'is_no_number.boolean' => 'O campo is_no_number deve ser verdadeiro ou falso.',
            'complement.max' => 'O campo complement deve ter no máximo 255 caracteres.',
            'neighborhood.alpha' => 'O campo neighborhood deve conter apenas letras.',
            'neighborhood.max' => 'O campo neighborhood deve ter no máximo 255 caracteres.',
            'postal_code.alpha' => 'O campo postal_code deve conter apenas letras.',
            'postal_code.max' => 'O campo postal_code deve ter no máximo 50 caracteres.',
            'city.max' => 'O campo city deve ter no máximo 50 caracteres.',
            'state.required' => 'O campo state é obrigatório.',
            'state.enum_key' => 'O campo state deve conter um valor válido.',
            'country.required' => 'O campo country é obrigatório.',
            'country.enum_key' => 'O campo country deve conter um valor válido.'
        ];
    }
}
