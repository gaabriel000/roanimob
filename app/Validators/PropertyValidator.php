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
                'title' => 'required|max:255',
                'description' => 'max:255',
                'status' => ['required', new EnumKey(PropertyStatus::class)],
                'display_price' => 'required|numeric',
                'address' => 'required|array'
            ],
            $addressValidator->mergeRules('address')
        );
    }

    public function messages(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
                'title.required' => 'O campo title é obrigatório.',
                'title.alpha' => 'O campo title deve conter apenas letras.',
                'title.max' => 'O campo title não pode exceder :max caracteres.',
                'description.max' => 'O campo description não pode exceder :max caracteres.',
                'status.required' => 'O campo status é obrigatório.',
                'display_price.required' => 'O campo price de exibição é obrigatório.',
                'display_price.numeric' => 'O campo price de exibição deve ser um número.',
                'address.required' => 'É obrigatório um array address para a propriedade',
                'address.array' => 'O campo address deve ser um array.'
            ],
            $addressValidator->mergeMessages('address')
        );
    }
}
