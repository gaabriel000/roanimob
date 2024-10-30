<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;
use ReflectionEnum;

class EnumKey implements ValidationRule
{
    protected string $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $reflectionEnum = new ReflectionEnum($this->enum);
        $keys = array_map(fn($case) => $case->name, $reflectionEnum->getCases());

        if (!in_array($value, $keys, true)) {
            $fail("O campo {$attribute} deve ser um dos valores válidos: " . implode(', ', $keys) . '.');
        }
    }
}
