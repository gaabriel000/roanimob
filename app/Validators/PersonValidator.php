<?php

namespace App\Validators;

use App\Enums\PersonType;
use App\Enums\DocumentType;
use Illuminate\Validation\Rules\Enum;

class PersonValidator extends BaseValidator
{
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(PersonType::class)],
            'first_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'email' => 'nullable|email',
            'tax_id' => 'required|num|max:50',
            'tax_type' => ['required', new Enum(DocumentType::class)],
            'document_number' => 'nullable|numeric|max:50',
            'birth_date' => 'required|date_format:d-m-Y'
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'O campo type é obrigatório e deve conter OWNER ou TENANT.',
            'first_name.required' => 'O campo first_name é obrigatório.',
            'first_name.alpha' => 'O campo first_name deve conter apenas letras.',
            'first_name.max' => 'O campo first_name deve ter no máximo 255 caracteres.',
            'last_name.required' => 'O campo last_name é obrigatório.',
            'last_name.alpha' => 'O campo last_name deve conter apenas letras.',
            'last_name.max' => 'O campo last_name deve ter no máximo 255 caracteres.',
            'email.email' => 'O campo email deve estar formatado corretamente: exemplo@mail.com',
            'tax_id.required' => 'O campo tax_id é obrigatório.',
            'tax_id.numeric' => 'O campo tax_id deve conter apenas números.',
            'tax_id.max' => 'O campo tax_id deve ter no máximo 50 caracteres.',
            'tax_type.required' => 'O campo tax_type é obrigatório e deve ser um dos tipos válidos: CPF, CNPJ ou OTHER.',
            'document_number.numeric' => 'O campo document_number deve conter apenas números.',
            'document_number.max' => 'O campo document_number deve ter no máximo 50 caracteres.',
            'birth_date.required' => 'O campo birth_date é obrigatório.',
            'birth_date.date_format' => 'O campo birth_date deve estar no formato dd-mm-aaaa.'
        ];
    }
}
