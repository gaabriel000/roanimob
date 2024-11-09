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
            $this->addressRules($addressValidator)
        );
    }

    private function addressRules(AddressValidator $addressValidator): array
    {
        $rules = [];

        foreach ($addressValidator->rules() as $key => $rule) {
            if (is_array($rule)) {
                foreach ($rule as $index => $r) {
                    if ($r === 'required') {
                        $rule[$index] = 'required_with:address,!null';
                    }
                }
            } else {
                $rule = preg_replace('/\brequired\b/', 'required_with:address,!null', $rule);
            }

            $rules["address.$key"] = $rule;
        }

        return $rules;
    }

    public function messages(): array
    {
        $addressValidator = new AddressValidator();

        return array_merge(
            [
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
                'tax_type.required' => 'O campo taxType é obrigatório e deve ser um dos tipos válidos: CPF, CNPJ ou OTHER.',
                'document_number.numeric' => 'O campo documentNumber deve conter apenas números.',
                'birth_date.date_format' => 'O campo birthDate deve estar no formato yyyy-MM-dd.'
            ],
            $this->addressMessages($addressValidator)
        );
    }

    private function addressMessages(AddressValidator $addressValidator): array
    {
        $messages = [];
        foreach ($addressValidator->messages() as $key => $message) {
            $messages["address.$key.required_if"] = "O campo $key é obrigatório quando o objeto address está presente.";
            $messages["address.$key"] = $message;
        }
        return $messages;
    }
}
