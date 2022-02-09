<?php

namespace App\Shared\Domain\Utils;

final class Strings
{
    public static function sanitizeAccents(string $string): string
    {
        $search = ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'];
        $replace = ['A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'];

        return str_replace($search, $replace, $string);
    }

    public static function slugify(string $string, string $separator = '-'): string
    {
        return preg_replace('/[\W]/', $separator, strtolower(self::sanitizeAccents($string)));
    }

    public static function toCamelCase(string $string): string
    {
        $string = trim(preg_replace('/[^a-z0-9]+/i', ' ', $string));
        $string = str_replace(' ', '', ucwords($string));

        return lcfirst($string);
    }

    public static function toSnakeCase(string $string): string
    {
        return ctype_lower($string) ? $string : strtolower(preg_replace('/[^A-Z]\s)([A-Z])/', '$1_$2', $string));
    }
}
