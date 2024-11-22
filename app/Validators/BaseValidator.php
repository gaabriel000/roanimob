<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use App\Utils\Converter;

abstract class BaseValidator
{
    abstract protected function rules(): array;

    abstract protected function messages(): array;

    public function validate(array &$data, bool $is_update = false): array
    {
        $data = Converter::convertKeysToSnakeCase($data);
        $rules = $this->rules();
        $messages = $this->messages();

        if ($is_update) {
            $this->removeRequirement($rules);
        }

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return [
                'valid' => false,
                'errors' => Converter::convertKeysToCamelCase($validator->errors()->toArray())
            ];
        }

        return ['valid' => true];
    }

    private function removeRequirement(&$rules)
    {
        foreach ($rules as &$rule) {
            if (is_array($rule)) {
                foreach ($rule as $index => $r) {
                    if ($r === 'required') {
                        $rule[$index] = '';
                    }
                }
            } else {
                $rule = preg_replace('/\brequired.*\|?/', '', $rule);
            }
        }
    }
}
