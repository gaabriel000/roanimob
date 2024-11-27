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
                $this->removeRequirementArray($rule);
            } else {
                $this->removeRequirementString($rule);
            }
        }
    }

    private function removeRequirementArray(array &$rule)
    {
        foreach ($rule as $index => $r) {
            if (is_string($r) && str_contains($r, 'required')) {
                unset($rule[$index]);
            }
        }
    }

    private function removeRequirementString(string &$rule)
    {
        $rules_array = explode('|', $rule);
        foreach ($rules_array as $r) {
            if (is_string($r) && str_contains($r, 'required')) {
                $rule = str_replace($r, '', $r);
            }
        }
    }

    public function mergeRules(string $object): array
    {
        $rules = [];

        foreach ($this->rules() as $key => $rule) {
            if (is_array($rule)) {
                foreach ($rule as $index => $r) {
                    if ($r === 'required') {
                        $rule[$index] = REQUIRED_WITH;
                    }
                }
            } else {
                $rule = preg_replace('/\brequired\b/', REQUIRED_WITH, $rule);
            }

            $rules["$object.$key"] = $rule;
        }

        return $rules;
    }

    public function mergeMessages(string $object): array
    {
        $messages = [];
        foreach ($this->messages() as $key => $message) {
            $key = preg_replace('/\brequired\b/', REQUIRED_WITH, $key);

            if (str_contains($key, REQUIRED_WITH)) {
                preg_match('/^([^.]+)/', $key, $field);
                $field_name = $field[1];

                preg_match('/^([^:]+)/', $key, $rule);
                $rule_name = $rule[1];

                $messages["$object.$rule_name"] = "O campo $field_name é obrigatório quando o objeto $object está presente.";
            } else {
                $messages["$object.$key"] = $message;
            }
        }

        return $messages;
    }
}
