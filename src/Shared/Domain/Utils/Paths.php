<?php

namespace App\Shared\Domain\Utils;

final class Paths
{
    public static function basename(string $path, string $separator = DIRECTORY_SEPARATOR)
    {
        if (false === strpos($path, $separator)) {
            return $path;
        }

        $pathMap = explode($separator, $path);

        return $pathMap[count($pathMap) - 1];

    }
}
