<?php

namespace App\Services;

use App\Services\PersonService;
use App\Services\PropertyService;
use App\Validators\ContractValidator;
use App\Repositories\ContractRepository;

class ContractService
{
    private PersonService $personService;
    private PropertyService $propertyService;
    private ContractRepository $contractRepository;

    public function __construct(PersonService $personService, PropertyService $propertyService, ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
        $this->personService = $personService;
        $this->propertyService = $propertyService;
    }

    public function create($request)
    {
        $data = $request->all();
        $validation_result = $this->validate($data);

        if (!$validation_result['valid']) {
            return response()->json($validation_result['errors'], $validation_result['status_code']);
        }

        $contract = $this->contractRepository->create($data);
        return response()->json($contract, 201);
    }

    public function renew($id)
    {
        $contract = $this->contractRepository->findById($id);

        if (!$contract) {
            return response()->json('Contrato não encontrado, ID: ' . $id, 404);
        }

        unset($contract['id']);
        $contract['parent_contract_id'] = $id;

        // adjust the date for equal period.

        return $this->contractRepository->create($contract);
    }

    public function delete($id)
    {
        $result = $this->contractRepository->delete($id);

        if (!$result) {
            return response()->json('Contrato não encontrado ou já removido, ID: ' . $id, 404);
        }

        return response()->json('Contrato removido com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $request)
    {
        $data = $request->all();
        $this->validate($data, true);

        $contract = $this->contractRepository->update($id, $data);

        if (!$contract) {
            return response()->json('Contrato não encontrado, ID: ' . $id, 404);
        }

        $contract = $this->contractRepository->update($id, $data);
        return response()->json($contract, 200);
    }

    public function query($request)
    {
        $data = $request->all();
        $contract = $this->queryData($data);

        if ($contract['data']) {
            return response()->json($contract, 200);
        } else {
            return response()->json($contract, 404);
        }
    }

    public function queryData(array &$data): array
    {
        return $this->contractRepository->findByAttributes($data);
    }

    private function validate(&$data, $update = false)
    {
        $validator = new ContractValidator();
        $validation_result = $validator->validate($data, $update);

        if (!$validation_result['valid']) {
            $validation_result['status_code'] = 400;
            return $validation_result;
        }

        return $this->validateRelation($data);
    }

    private function validateRelation(&$data)
    {
        $errors = [];
        $owner_id = $data['owner_id'];
        $owner = $this->personService->queryData(['id' => $owner_id, 'type' => 'OWNER'])['data'];

        if (!$owner) {
            $errors = array_merge($errors, ['ownerId' => "Proprietário não encontrado com ownerId: $owner_id"]);
        }

        $tenant_id = $data['tenant_id'];
        $tenant = $this->personService->queryData(['id' => $tenant_id, 'type' => 'TENANT'])['data'];

        if (!$tenant) {
            $errors = array_merge($errors, ['tenantId' => "Inquilino não encontrado com tenantId: $tenant_id"]);
        }

        $property_id = $data['property_id'];
        $property = $this->propertyService->queryData(['id' => $property_id])['data'];

        if (!$property) {
            $errors = array_merge($errors, ['propertyId' => "Propriedade não encontrada com propertyId: $property_id"]);
        }

        if ($errors) {
            return [
                'status_code' => 404,
                'valid' => false,
                'errors' => $errors
            ];
        }

        return ['valid' => true];
    }
}
