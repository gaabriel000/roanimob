<?php

namespace App\Validators;

use App\Enums\ContractStatus;
use App\Enums\PaymentDateType;
use App\Enums\GuaranteeType;
use App\Rules\EnumKey;
use App\Validators\ContractRenewValidator;

class ContractValidator extends BaseValidator
{
    public function rules(): array
    {
        $renewValidator = new ContractRenewValidator();

        return array_merge(
            [
                'rent_amount' => 'required|numeric',
                'guarantee_type' => ['required', new EnumKey(GuaranteeType::class)],
                'due_date' => 'required|numeric|between:1,28',
                'payment_date_type' => ['required', new EnumKey(PaymentDateType::class)],
                'status' => ['required', new EnumKey(ContractStatus::class)],
                'owner_id' => 'required|uuid',
                'tenant_id' => 'required|uuid',
                'property_id' => 'required|uuid',
                'parent_contract_id' => 'uuid'
            ],
            $renewValidator->rules()
        );
    }

    public function messages(): array
    {
        $renewValidator = new ContractRenewValidator();

        return array_merge(
            [
                'rent_amount.required' => 'O campo rentAmount é obrigatório.',
                'rent_amount.numeric' => 'O campo rentAmount deve ser numérico decimal.',
                'guarantee_type.required' => 'O campo guaranteeType é obrigatório.',
                'due_date.required' => 'O campo dueDate é obrigatório.',
                'due_date.numeric' => 'O campo dueDate deve ser numérico inteiro.',
                'due_date.between' => 'O campo dueDate deve estar entre 1 e 28.',
                'payment_date_type.required' => 'O campo paymentDateType é obrigatório',
                'status.required' => 'O campo status é obrigatório.',
                'owner_id.required' => 'O campo ownerId é obrigatório.',
                'owner_id.uuid' => 'O campo ownerId deve ser um UUID válido.',
                'tenant_id.required' => 'O campo tenantId é obrigatório.',
                'tenant_id.uuid' => 'O campo tenantId deve ser um UUID válido.',
                'property_id.required' => 'O campo propertyId é obrigatório.',
                'property_id.uuid' => 'O campo propertyId deve ser um UUID válido.',
                'parent_contract_id.uuid' => 'O campo parentContractId deve ser um UUID válido.',
            ],
            $renewValidator->messages()
        );
    }
}
