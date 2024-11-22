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
            'postal_code.alpha' => 'O campo postal_code deve conter apenas letras.',
            'postal_code.max' => 'O campo postal_code deve ter no máximo 50 caracteres.',
            'city.max' => 'O campo city deve ter no máximo 50 caracteres.',
            'state.required' => 'O campo state é obrigatório.',
            'state.enum_key' => 'O campo state deve conter um valor válido.',
            'country.required' => 'O campo country é obrigatório.',
            'country.enum_key' => 'O campo country deve conter um valor válido.'
        ];
    }

    public function addressRules(): array
    {
        $rules = [];

        foreach ($this->rules() as $key => $rule) {
            if (is_array($rule)) {
                foreach ($rule as $index => $r) {
                    if ($r === 'required') {
                        $rule[$index] = REQUIRED_WITH;
                    }
                }
            } else {
                $rule = preg_replace('/\brequired\b/', REQUIRED_WITH, $rule);
            }

            $rules["address.$key"] = $rule;
        }

        return $rules;
    }

    public function addressMessages(): array
    {
        $messages = [];
        foreach ($this->messages() as $key => $message) {
            $key = preg_replace('/\brequired\b/', REQUIRED_WITH, $key);

            if (str_contains($key, REQUIRED_WITH)) {
                preg_match('/^([^.]+)/', $key, $field);
                $field_name = $field[1];

                preg_match('/^([^:]+)/', $key, $rule);
                $rule_name = $rule[1];

                $messages["address.$rule_name"] = "O campo $field_name é obrigatório quando o objeto address está presente.";
            } else {
                $messages["address.$key"] = $message;
            }
        }

        return $messages;
    }
}
