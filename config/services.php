<?php

use Connor\DoReMi\Application;
use Framadate\FramaDB;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

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

return function (Application $application): ContainerInterface {
    $builder = new ContainerBuilder();

    configDatabase($builder, $application);

    $builder->compile();
    return $builder;
};
