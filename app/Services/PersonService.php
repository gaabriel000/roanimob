<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use App\Validators\PersonValidator;

class PersonService extends BaseService
{
    private PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function create($data)
    {
        $validator = new PersonValidator();
        $validation_result = $validator->validate($data);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $person = $this->createPersonAndAddress($data);
        return $this->response($person, 201);
    }

    private function createPersonAndAddress(array $data): array
    {
        $address_id = null;

        if (isset($data['address'])) {
            $address_data = $data['address'];

            if (isset($address_data['id'])) {
                $address_id = $address_data['id'];
                $person = $this->personRepository->createAndUpdateAddress($data, $address_data, $address_id);
            } else {
                $person = $this->personRepository->createWithAddress($data, $address_data);
            }
        } else {
            $person = $this->personRepository->create($data);
        }

        return $person;
    }

    public function delete($id)
    {
        $result = $this->personRepository->delete($id);

        if (!$result) {
            return $this->response('Pessoa não encontrada ou já removida, ID: ' . $id, 404);
        }

        return $this->response('Pessoa removida com sucesso, ID: ' . $id, 200);
    }

    public function update($id, $data)
    {
        $validator = new PersonValidator();
        $validation_result = $validator->validate($data, true);

        if (!$validation_result['valid']) {
            return $this->response($validation_result['errors'], 400);
        }

        $person = $this->updateData($id, $data);

        if (!$person) {
            return $this->response('Pessoa não encontrada, ID: ' . $id, 404);
        }

        return $this->response($person, 200);
    }

    public function updateData($id, $data)
    {
        $address_id = null;

        if (isset($data['address'])) {
            $address_data = $data['address'];

            if (isset($address_data['id'])) {
                $address_id = $address_data['id'];
                $person = $this->personRepository->UpdateAndUpdateAddress($data, $address_data, $id, $address_id);
            } else {
                $person = $this->personRepository->UpdateAndCreateAddress($data, $address_data, $id);
            }
        } else {
            $person = $this->personRepository->update($id, $data);
        }

        return $person;
    }

    public function query($data)
    {
        $person = $this->queryData($data);

        if ($person['data']) {
            return $this->response($person, 200);
        } else {
            return $this->response($person, 404);
        }
    }

    public function queryData(array $data): array
    {
        $query_relation = isset($data['include_address']) && $data['include_address'] === 'true' ? ['address'] : [];
        $per_page = isset($data['per_page']) ? $data['per_page'] : 10;
        $page = isset($data['page']) ? $data['page'] : 1;

        return $this->personRepository->findByAttributes($data, $query_relation, $per_page, $page);
    }
}
