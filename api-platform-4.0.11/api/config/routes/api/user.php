<?php

use App\Controller\UserController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $route){
    $prefix = '/users';
    $route
        ->add('api_user_create', $prefix)
        ->methods(['POST'])
        ->controller([UserController::class, 'create'])

        ->add('api_user_index', $prefix)
        ->methods(['GET'])
        ->controller([UserController::class, 'index'])

        ->add('api_user_select',$prefix.'/{id}')
        ->methods(['GET'])
        ->controller([UserController::class, 'select'])

        ->add('api_user_delete',$prefix.'/{id}')
        ->methods(['DELETE'])
        ->controller([UserController::class, 'delete'])

        ->add('api_user_update',$prefix.'/{id}')
        ->methods(['PATCH'])
        ->controller([UserController::class, 'update'])
    ;
};
