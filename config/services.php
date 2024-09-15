<?php

use Connor\DoReMi\Application;
use Connor\DoReMi\Twig\Extensions\RoutingExtension;
use Framadate\FramaDB;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Compiler\RegisterServiceSubscribersPass;
use Symfony\Component\DependencyInjection\Compiler\ResolveServiceSubscribersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function configDatabase(ContainerBuilder $builder, Application $application): void
{
    $definition = new Definition(FramaDB::class);
    $definition->setArguments([
        $application->getConfiguration()->getDatabaseDsn(),
        $application->getConfiguration()->getDatabaseUser(),
        $application->getConfiguration()->getDatabasePassword(),
    ]);
    $definition->setPublic(true);

    $builder->setDefinition(FramaDB::class, $definition);
}

function configTwigExtensions(ContainerBuilder $builder, Application $application): void
{
    $definition = new Definition(RoutingExtension::class);
    $definition->setAutowired(true);
    $definition->setAutoconfigured(true);
    $definition->addTag('twig.extension');
    $builder->setDefinition(RoutingExtension::class, $definition);
}

function configTwig(ContainerBuilder $builder, Application $application): void
{
    $definition = new Definition(FilesystemLoader::class);
    $definition->setArguments([Application::ROOT_DIR.'/templates']);
    $builder->setDefinition(FilesystemLoader::class, $definition);

    $definition = new Definition(Environment::class);
    $definition->setAutoconfigured(true);
    $definition->setArgument('$loader', $builder->getDefinition(FilesystemLoader::class));

    $options = [
        'cache' => Application::ROOT_DIR.'/var/twig_cache',
        'debug' => $application->getConfiguration()->isDebug(),
    ];

    $definition->setArgument('$options', $options);
    $definition->setPublic(true);
    $builder->setDefinition(Environment::class, $definition);

    $currentMethodCalls = $definition->getMethodCalls();
    $extensionsMethodCalls = [];

    foreach ($builder->findTaggedServiceIds('twig.extension') as $serviceId => $extension) {
        $extensionsMethodCalls[] = ['addExtension', [$builder->getDefinition($serviceId)]];
    }

    $definition->setMethodCalls(array_merge($extensionsMethodCalls, $currentMethodCalls));
}

function configControllers(ContainerBuilder $builder, Application $application): void
{
    foreach (glob(Application::ROOT_DIR.'/src/Controllers/*.php') as $controllerFilePath) {
        $controllerName = basename($controllerFilePath, '.php');
        $controllerFCQN = sprintf('Connor\\DoReMi\\Controllers\\%s', $controllerName);

        $definition = new Definition($controllerFCQN);
        $definition->setAutoconfigured(true);
        $definition->setAutowired(true);
        $definition->setPublic(true);

        $refl = new \ReflectionClass($controllerFCQN);
        if ($refl->implementsInterface(ServiceSubscriberInterface::class)) {
            $definition->addTag('container.service_subscriber');
        }

        $builder->setDefinition($controllerFCQN, $definition);
    }

    $builder->addCompilerPass(new RegisterServiceSubscribersPass());
    $builder->addCompilerPass(new ResolveServiceSubscribersPass());
}

function configUrlGenerator(ContainerBuilder $builder, Application $application): void
{
    $definition = new Definition(UrlGenerator::class);
    $definition->setPublic(true);
    $definition->setArgument('$routes', $application->getRoutes());
    $definition->setArgument('$context', $application->getRequestContext());
    $builder->setDefinition(UrlGenerator::class, $definition);
}

return function (Application $application): ContainerInterface {
    $builder = new ContainerBuilder();

    configDatabase($builder, $application);
    configTwigExtensions($builder, $application);
    configTwig($builder, $application);
    configUrlGenerator($builder, $application);
    configControllers($builder, $application);

    $builder->compile();
    return $builder;
};
