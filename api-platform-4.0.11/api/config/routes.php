<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $routes)
{
    $routes->import('./routes/api/api.php')->prefix('/api');
};
#controllers:
    #resource:
    #    path: ../src/Controller/
    #    namespace: App\Controller
    #type: attribute
#api_route:
    #resource: './routes/api.yaml'
    #prefix: /api

