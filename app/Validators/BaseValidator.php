<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use App\Utils\Converter;

abstract class BaseValidator
{
    /**
     * Mandatory abstract function for validation rules
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * Mandatory abstract function for validation message
     * @return array
     */
    abstract protected function messages(): array;

    /**
     * Validation default method based on child rules and messages.
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $data = Converter::convertKeysToSnakeCase($data);
        $validator = Validator::make($data, $this->rules(), $this->messages());

        if ($validator->fails()) {
            return [
                'valid' => false,
                'errors' => Converter::convertKeysToCamelCase($validator->errors()->toArray())
            ];
        }

        return ['valid' => true];
    }
}
