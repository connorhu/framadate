<?php

use Connor\DoReMi\Application;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return function (Application $application): ContainerInterface {
    $builder = new ContainerBuilder();

    $builder->compile();
    return $builder;
};
