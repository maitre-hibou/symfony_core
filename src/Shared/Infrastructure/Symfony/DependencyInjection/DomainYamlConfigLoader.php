<?php

namespace App\Shared\Infrastructure\Symfony\DependencyInjection;

use App\Shared\Domain\Utils\Paths;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class DomainYamlConfigLoader
{
    public static function loadConfig(string $projectDir, LoaderInterface $loader, string $environment): void
    {
        $files = static::recursiveGlob($projectDir.'/src/*.{yaml,yml}', GLOB_BRACE);
        array_walk($files, static function (string $file) use (&$tmp, $loader, $environment): void {
            if (1 === preg_match(sprintf('/Infrastructure\/Symfony\/DependencyInjection\/config(_%s)?.ya?ml$/', $environment), $file)) {
                $loader->load($file);
            }
        });
    }

    public static function loadRoutingConfig(string $projectDir, RoutingConfigurator $routes): void
    {
        $files = static::recursiveGlob($projectDir.'/src/*.{yaml,yml}', GLOB_BRACE);
        array_walk($files, static function (string $file) use ($routes): void {
            if (1 === preg_match('/Infrastructure\/Symfony\/Routing\/routes.ya?ml$/', $file)) {
                $routes->import($file);
            }
        });
    }

    private static function recursiveGlob(string $pattern, int $flags): array
    {
        $files = glob($pattern, $flags);
        foreach (glob(\dirname($pattern).'/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, self::recursiveGlob($dir.'/'.Paths::basename($pattern), $flags));
        }

        return $files;
    }
}
