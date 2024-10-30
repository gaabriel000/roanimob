<?php

namespace App\Utils;

use Illuminate\Support\Str;

class CaseConverter
{
    /**
     * Convert all array keys to snake_case.
     *
     * @param array $data
     * @return array
     */
    public static function convertKeysToSnakeCase(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $snakeKey = Str::snake($key);
            $result[$snakeKey] = is_array($value) ? self::convertKeysToSnakeCase($value) : $value;
        }
        return $result;
    }

    /**
     * Convert all array keys to camelCase.
     *
     * @param array $data
     * @return array
     */
    public static function convertKeysToCamelCase(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $camelKey = Str::camel($key);
            $result[$camelKey] = is_array($value) ? self::convertKeysToCamelCase($value) : $value;
        }
        return $result;
    }
}
