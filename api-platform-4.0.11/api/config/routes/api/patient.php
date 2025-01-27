<?php

use App\Controller\PatientController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $route){
    $prefix = '/patients';
    $route
        ->add('api_patient_create', $prefix)
        ->methods(['POST'])
        ->controller([PatientController::class, 'create'])

        ->add('api_patient_index', $prefix)
        ->methods(['GET'])
        ->controller([PatientController::class, 'index'])

        ->add('api_patient_select',$prefix.'/{id}')
        ->methods(['GET'])
        ->controller([PatientController::class, 'select'])

        ->add('api_patient_delete',$prefix.'/{id}')
        ->methods(['DELETE'])
        ->controller([PatientController::class, 'delete'])

        ->add('api_patient_update',$prefix.'/{id}')
        ->methods(['PATCH'])
        ->controller([PatientController::class, 'update'])
    ;
};
