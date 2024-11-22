<?php

namespace App\Validators;

use App\Enums\PropertyStatus;
use App\Rules\EnumKey;
use App\Validators\AddressValidator;

class PropertyValidator extends BaseValidator
{
    public function rules(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
                'title' => 'required|alpha|max:255',
                'description' => 'max:255',
                'status' => ['required', new EnumKey(PropertyStatus::class)],
                'display_price' => 'required|numeric',
                'address' => 'required|array'
            ],
            $addressValidator->addressRules()
        );
    }

    public function messages(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
                'title.required' => 'O título é obrigatório.',
                'title.alpha' => 'O título deve conter apenas letras.',
                'title.max' => 'O título não pode exceder :max caracteres.',
                'description.max' => 'A descrição não pode exceder :max caracteres.',
                'status.required' => 'O status é obrigatório.',
                'status.enum_key' => 'O status deve conter um valor válido: OPEN, RENTED, CONTRACT, DISABLED.',
                'display_price.required' => 'O preço de exibição é obrigatório.',
                'display_price.numeric' => 'O preço de exibição deve ser um número.',
                'address.required' => 'É obrigatório um endereço para a propriedade',
                'address.array' => 'O endereço deve ser um array.'
            ],
            $addressValidator->addressMessages()
        );
    }
}
