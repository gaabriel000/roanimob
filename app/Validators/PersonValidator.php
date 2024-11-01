<?php

namespace App\Validators;

use App\Enums\PersonType;
use App\Enums\DocumentType;
use App\Rules\EnumKey;

class PersonValidator extends BaseValidator
{
    public function rules(): array
    {
        return [
            'type' => ['required', new EnumKey(PersonType::class)],
            'first_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'email' => 'nullable|email',
            'tax_id' => 'required|numeric|max:50',
            'tax_type' => ['required', new EnumKey(DocumentType::class)],
            'document_number' => 'nullable|numeric',
            'birth_date' => 'required|date_format:Y-m-d'
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'O campo type é obrigatório e deve conter apenas os valores OWNER ou TENANT.',
            'first_name.required' => 'O campo firstName é obrigatório.',
            'first_name.alpha' => 'O campo firstName deve conter apenas letras.',
            'first_name.max' => 'O campo firstName deve ter no máximo 255 caracteres.',
            'last_name.required' => 'O campo lastName é obrigatório.',
            'last_name.alpha' => 'O campo lastName deve conter apenas letras.',
            'last_name.max' => 'O campo lastName deve ter no máximo 255 caracteres.',
            'email.email' => 'O campo email deve estar formatado corretamente: exemplo@mail.com',
            'tax_id.required' => 'O campo taxId é obrigatório.',
            'tax_id.numeric' => 'O campo taxId deve conter apenas números.',
            'tax_id.max' => 'O campo taxId deve ter no máximo 50 caracteres.',
            'tax_type.required' => 'O campo taxType é obrigatório e deve ser um dos tipos válidos: CPF, CNPJ ou OTHER.',
            'document_number.numeric' => 'O campo documentNumber deve conter apenas números.',
            'birth_date.required' => 'O campo birthDate é obrigatório.',
            'birth_date.date_format' => 'O campo birthDate deve estar no formato yyyy-MM-dd.'
        ];
    }
}
