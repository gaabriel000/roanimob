<?php

namespace App\Validators;

use App\Enums\PersonType;
use App\Enums\DocumentType;
use App\Rules\EnumKey;
use App\Validators\AddressValidator;

class PersonValidator extends BaseValidator
{
    public function rules(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
                'type' => ['required', new EnumKey(PersonType::class)],
                'first_name' => 'required|alpha|max:255',
                'last_name' => 'required|alpha|max:255',
                'email' => 'nullable|email',
                'phone_number' => 'nullable',
                'tax_id' => 'required|numeric',
                'tax_type' => ['required', new EnumKey(DocumentType::class)],
                'document_number' => 'nullable|numeric',
                'birth_date' => 'date_format:Y-m-d',
                'address' => 'nullable|array'
            ],
            $addressValidator->addressRules()
        );
    }

    public function messages(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
                'type.required' => 'O campo type é obrigatório.',
                'first_name.required' => 'O campo firstName é obrigatório.',
                'first_name.alpha' => 'O campo firstName deve conter apenas letras.',
                'first_name.max' => 'O campo firstName deve ter no máximo 255 caracteres.',
                'last_name.required' => 'O campo lastName é obrigatório.',
                'last_name.alpha' => 'O campo lastName deve conter apenas letras.',
                'last_name.max' => 'O campo lastName deve ter no máximo 255 caracteres.',
                'email.email' => 'O campo email deve estar formatado corretamente: exemplo@mail.com',
                'tax_id.required' => 'O campo taxId é obrigatório.',
                'tax_id.numeric' => 'O campo taxId deve conter apenas números.',
                'tax_type.required' => 'O campo taxType é obrigatório.',
                'document_number.numeric' => 'O campo documentNumber deve conter apenas números.',
                'birth_date.date_format' => 'O campo birthDate deve estar no formato yyyy-MM-dd.'
            ],
            $addressValidator->addressMessages()
        );
    }
}
