<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('api_login', '/auth')
        ->methods(['POST'])
    ;
    $routes->import('./patient.php');
    $routes->import('./user.php');
    $routes->import('./address.php');
};

