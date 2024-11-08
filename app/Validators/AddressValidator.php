<?php

namespace App\Validators;

use App\Enums\PersonType;
use App\Enums\DocumentType;
use App\Rules\EnumKey;
use App\Enums\State;
use App\Enums\Country;

class PersonValidator extends BaseValidator
{
    public function rules(): array
    {
        return [
            'street' => 'required|alpha|max:50',
            'number' => 'number|required_if:is_no_number,false',
            'is_no_number' => 'required|boolean',
            'complement' => 'alpha|max:255',
            'neighborhood' => 'alpha|max:255',
            'postal_code' => 'alpha|max:50',
            'city' => 'alpha|max:50',
            'state' => ['required', new EnumKey(State::class)],
            'country ' => ['required', new EnumKey(Country::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'street.required' => 'O campo street é obrigatório.',
            'street.alpha' => 'O campo street deve conter apenas letras.',
            'street.max' => 'O campo street deve ter no máximo 50 caracteres.',
            'number.required_if' => 'O campo number é obrigatório quando o campo is_no_number for falso.',
            'number.number' => 'O campo number deve conter apenas números.',
            'is_no_number.required' => 'O campo is_no_number é obrigatório.',
            'is_no_number.boolean' => 'O campo is_no_number deve ser verdadeiro ou falso.',
            'complement.alpha' => 'O campo complement deve conter apenas letras.',
            'complement.max' => 'O campo complement deve ter no máximo 255 caracteres.',
            'neighborhood.alpha' => 'O campo neighborhood deve conter apenas letras.',
            'neighborhood.max' => 'O campo neighborhood deve ter no máximo 255 caracteres.',
            'postal_code.alpha' => 'O campo postal_code deve conter apenas letras.',
            'postal_code.max' => 'O campo postal_code deve ter no máximo 50 caracteres.',
            'city.alpha' => 'O campo city deve conter apenas letras.',
            'city.max' => 'O campo city deve ter no máximo 50 caracteres.',
            'state.required' => 'O campo state é obrigatório.',
            'state.enum_key' => 'O campo state deve conter um valor válido.',
            'country.required' => 'O campo country é obrigatório.',
            'country.enum_key' => 'O campo country deve conter um valor válido.'
        ];
    }
}
