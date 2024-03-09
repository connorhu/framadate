<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('main', '/')
        ->controller([DefaultController::class, 'main'])
    ;
};
