<?php

use App\Controller\AddressController;
use App\Controller\PatientController;
use App\Controller\UserController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('api_login', '/auth')
        ->methods(['POST'])

        ->add('api_user_create','/users')
        ->methods(['POST'])
        ->controller([UserController::class, 'create'])

        ->add('api_user_index','/users')
        ->methods(['GET'])
        ->controller([UserController::class, 'index'])

        ->add('api_user_select','/users/{id}')
        ->methods(['GET'])
        ->controller([UserController::class, 'select'])

        ->add('api_user_delete','/users/{id}')
        ->methods(['DELETE'])
        ->controller([UserController::class, 'delete'])

        ->add('api_user_update','/users/{id}')
        ->methods(['PATCH'])
        ->controller([UserController::class, 'update'])

        ->add('api_address_create','/address')
        ->methods(['POST'])
        ->controller([AddressController::class, 'create'])

        ->add('api_address_index','/address')
        ->methods(['POST'])
        ->controller([AddressController::class, 'index'])

        ->add('api_address_select','/address/{id}')
        ->methods(['GET'])
        ->controller([AddressController::class, 'select'])

        ->add('api_address_delete','/address/{id}')
        ->methods(['DELETE'])
        ->controller([AddressController::class, 'delete'])

        ->add('api_address_update','/address/{id}')
        ->methods(['PATCH'])
        ->controller([AddressController::class, 'update'])

        ->add('api_patient_create','/address')
        ->methods(['POST'])
        ->controller([PatientController::class, 'create'])

        ->add('api_patient_index','/patients')
        ->methods(['POST'])
        ->controller([PatientController::class, 'index'])

        ->add('api_patient_select','/patients/{id}')
        ->methods(['GET'])
        ->controller([PatientController::class, 'select'])

        ->add('api_patient_select','/patients')
        ->methods(['GET'])
        ->controller([PatientController::class, 'index'])

        ->add('api_patient_delete','/patients/{id}')
        ->methods(['DELETE'])
        ->controller([PatientController::class, 'delete'])

        ->add('api_patient_update','/patients/{id}')
        ->methods(['PATCH'])
        ->controller([PatientController::class, 'update'])

    ;
};

