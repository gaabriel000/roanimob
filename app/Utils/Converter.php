<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Converter
{
    public static function convertKeysToSnakeCase(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $snakeKey = Str::snake($key);
            $result[$snakeKey] = is_array($value) ? self::convertKeysToSnakeCase($value) : $value;
        }
        return $result;
    }

    public static function convertKeysToCamelCase(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $camelKey = Str::camel($key);
            $result[$camelKey] = is_array($value) ? self::convertKeysToCamelCase($value) : $value;
        }
        return $result;
    }

    public static function objectToArray($object): array
    {
        return json_decode(json_encode($object), true);
    }

    public static function sortResponseId($array): array
    {
        $id = $array['id'];
        unset($array[$id]);
        return array_merge(['id' => $id], $array);
    }
}
