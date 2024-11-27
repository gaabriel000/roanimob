<?php

namespace App\Validators;

class ContractRenewValidator extends BaseValidator
{
    public function rules(): array
    {
        return [
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date_format:Y-m-d'
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'O campo startDate é obrigatório.',
            'start_date.date_format' => 'O campo startDate deve estar no formato YYYY-MM-DD.',
            'start_date.before' => 'O campo startDate deve ser anterior ao endDate',
            'end_date.required' => 'O campo endDate é obrigatório.',
            'end_date.date_format' => 'O campo endDate deve estar no formato YYYY-MM-DD.'
        ];
    }
}
