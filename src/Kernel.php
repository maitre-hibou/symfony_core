<?php

namespace App;

use App\Shared\Infrastructure\Symfony\DependencyInjection\DomainYamlConfigLoader;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader
    ): void {
        $configDir = $this->getConfigDir();

        $container->import($configDir.'/{packages}/*.yaml');
        $container->import($configDir.'/{packages}/'.$this->environment.'/*.yaml');

        if (is_file($configDir.'/services.yaml')) {
            $container->import($configDir.'/services.yaml');
            $container->import($configDir.'/{services}_'.$this->environment.'.yaml');
        } else {
            $container->import($configDir.'/{services}.php');
        }

        DomainYamlConfigLoader::loadConfig($this->getProjectDir(), $loader, $this->environment);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $configDir = $this->getConfigDir();

        $routes->import($configDir.'/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($configDir.'/{routes}/*.yaml');

        if (is_file($configDir.'/routes.yaml')) {
            $routes->import($configDir.'/routes.yaml');
        } else {
            $routes->import($configDir.'/{routes}.php');
        }

        DomainYamlConfigLoader::loadRoutingConfig($this->getProjectDir(), $routes);
    }
}
