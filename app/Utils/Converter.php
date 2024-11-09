<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Converter
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

    /**
     * Safely convert object properties to an array. Avoid object nesting.
     *
     * @param object $data
     * @return array
     */
    public static function objectToArray($object): array
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * Sort array response and top the ID in the object order
     *
     * @param array @array
     * @return array
     */
    public static function sortResponseId($array): array
    {
        $id = $array['id'];
        unset($array[$id]);
        return array_merge(['id' => $id], $array);
    }
}
