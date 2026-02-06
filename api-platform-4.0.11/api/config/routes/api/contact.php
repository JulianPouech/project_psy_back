<?php

use App\Controller\ContactController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $routing){
    $routing->add('api_contact','contact')
        ->controller([ContactController::class,'contact'])
    ;
};
