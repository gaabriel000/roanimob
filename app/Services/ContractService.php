<?php

namespace App\Services;

use App\Services\PersonService;
use App\Services\PropertyService;
use App\Validators\ContractValidator;
use App\Repositories\ContractRepository;
use App\Validators\ContractRenewValidator;

class ContractService extends BaseService
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

    public function create($data)
    {
        $validation_result = $this->validate($data);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], $validation_result['status_code']);
        }

        $contract = $this->contractRepository->create($data);
        return $this->response($contract, 201);
    }

    public function renew($id, $data)
    {
        $validator = new ContractRenewValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $contract = $this->contractRepository->findById($id);

        if (!$contract) {
            return $this->response('Contrato não encontrado, ID: ' . $id, 404);
        }

        $old_contract = $contract;
        $old_contract['status'] = 'RENEW';

        unset($contract['id']);
        $contract['parent_contract_id'] = $id;
        $contract['start_date'] = $data['start_date'];
        $contract['end_date'] = $data['end_date'];

        return $this->contractRepository->renew($old_contract, $contract);
    }

    public function delete($id)
    {
        $result = $this->contractRepository->delete($id);

        if (!$result) {
            return $this->response('Contrato não encontrado ou já removido, ID: ' . $id, 404);
        }

        return $this->response('Contrato removido com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $data)
    {
        $validation_result = $this->validate($data, true);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], $validation_result['status_code']);
        }

        $contract = $this->contractRepository->update($id, $data);

        if (!$contract) {
            return $this->response('Contrato não encontrado, ID: ' . $id, 404);
        }

        $contract = $this->contractRepository->update($id, $data);
        return $this->response($contract, 200);
    }

    public function query($data)
    {
        $contract = $this->queryData($data);

        if ($contract['data']) {
            return $this->response($contract, 200);
        } else {
            return $this->response($contract, 404);
        }
    }

    public function queryData(array &$data): array
    {
        $query_relation = [];

        if (isset($data['include_owner']) && $data['include_owner'] === 'true') {
            array_push($query_relation, 'owner');
        }

        if (isset($data['include_tenant']) && $data['include_tenant'] === 'true') {
            array_push($query_relation, 'tenant');
        }

        if (isset($data['include_property']) && $data['include_property'] === 'true') {
            array_push($query_relation, 'property');
        }

        $per_page = isset($data['per_page']) ? $data['per_page'] : 10;
        $page = isset($data['page']) ? $data['page'] : 1;

        return $this->contractRepository->findByAttributes($data, $query_relation, $per_page, $page);
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

        if (isset($data['owner_id'])) {
            $owner_id = $data['owner_id'];
            $owner = $this->personService->queryData(['id' => $owner_id, 'type' => 'OWNER'])['data'];

            if (!$owner) {
                $errors = array_merge($errors, ['ownerId' => "Proprietário não encontrado com ownerId: $owner_id"]);
            }
        }

        if (isset($data['tenant_id'])) {
            $tenant_id = $data['tenant_id'];
            $tenant = $this->personService->queryData(['id' => $tenant_id, 'type' => 'TENANT'])['data'];
    
            if (!$tenant) {
                $errors = array_merge($errors, ['tenantId' => "Inquilino não encontrado com tenantId: $tenant_id"]);
            }
        }

        if (isset($data['property_id'])) {
            $property_id = $data['property_id'];
            $property = $this->propertyService->queryData(['id' => $property_id])['data'];
    
            if (!$property) {
                $errors = array_merge($errors, ['propertyId' => "Propriedade não encontrada com propertyId: $property_id"]);
            }
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
