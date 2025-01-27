<?php

use App\Controller\AddressController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $route){
    $prefix = '/address';
    $route
        ->add('api_address_create', $prefix)
        ->methods(['POST'])
        ->controller([AddressController::class, 'create'])

        ->add('api_address_index', $prefix)
        ->methods(['GET'])
        ->controller([AddressController::class, 'index'])

        ->add('api_address_select',$prefix.'/{id}')
        ->methods(['GET'])
        ->controller([AddressController::class, 'select'])

        ->add('api_address_delete',$prefix.'/{id}')
        ->methods(['DELETE'])
        ->controller([AddressController::class, 'delete'])

        ->add('api_address_update',$prefix.'/{id}')
        ->methods(['PATCH'])
        ->controller([AddressController::class, 'update'])
    ;
};
