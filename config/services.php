<?php

use Connor\DoReMi\Application;
use Framadate\FramaDB;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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

function configTwig(ContainerBuilder $builder, Application $application): void
{
    $definition = new Definition(FilesystemLoader::class);
    $definition->setArguments([Application::ROOT_DIR.'/templates']);
    $builder->setDefinition(FilesystemLoader::class, $definition);

    $definition = new Definition(Environment::class);
    $definition->setAutoconfigured(true);
    $definition->setArgument('$options', [
        'cache' => Application::ROOT_DIR.'/var/twig_cache',
    ]);
    $definition->setPublic(true);
    $builder->setDefinition(FilesystemLoader::class, $definition);
}

return function (Application $application): ContainerInterface {
    $builder = new ContainerBuilder();

    configDatabase($builder, $application);
    configTwig($builder, $application);

    $builder->compile();
    return $builder;
};
