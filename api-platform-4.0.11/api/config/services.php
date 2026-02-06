<?php

use App\EventListener\AuthenticationSuccessListener;
use App\EventListener\JwtCreatedListener;
use App\EventListener\MailerListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Event,Kernel.php}')
        ->public()
    ;

    $services->set(AuthenticationSuccessListener::class)
        ->tag('kernel.event_listener', ['event' => 'lexik_jwt_authentication.on_authentication_success',
            'method' => 'onAuthenticationSuccessResponse'
        ]);
    ;

    $services->set(JwtCreatedListener::class)
        ->tag('kernel.event_listener', [ 'event' => 'lexik_jwt_authentication.on_jwt_created',
            'method' => 'onCreatedJwt'
        ])
    ;

    $services->set(MailerListener::class)
        ->tag('kernel.event_listener', [ 'event' => 'onContact', 'method' => 'onContact'])
        ->tag('kernel.event_listener', [ 'event' => 'onSinging', 'method' => 'onSinging'])
        ->arg('$emailContact','%env(MAIL_CONTACT)%')
        ->arg('$emailServer','%env(MAIL_SERVER)%')
        ->public()
    ;



};
# This file is the entry point to configure your own services.
# Files in the packages/ subdirectory configure your dependencies.

# Put parameters here that don't need to change on each machine where the app is deployed
## https://symfony.com/doc/current/best_practices.html#use-parameters-for-application-configuration
#parameters:
#
#services:
#    # default configuration for services in *this* file
#    _defaults:
#        autowire: true      # Automatically injects dependencies in your services.
#        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.
#
#    # makes classes in src/ available to be used as services
#    # this creates a service per class whose id is the fully-qualified class name
#    App\Security\JwtSecurity:
#        public: true
#    App\:
#        resource: '../src/'
#        exclude:
#            - '../src/DependencyInjection/'
#            - '../src/Entity/'
#            - '../src/Kernel.php'
#        public: true
#
#    App\EventListener\AuthenticationSuccessListener:
#        public: true
#        tags:
#            - { name: kernel.event_listener, event: lexik_jwt_authentication.on_authentication_success, method: onAuthenticationSuccessResponse }
#
#    App\EventListener\JwtCreatedListener:
#        public: true
#        tags:
#            - { name: kernel.event_listener, event: lexik_jwt_authentication.on_jwt_created, method: onCreatedJwt }
#    # add more service definitions when explicit configuration is needed
#    # please note that last definitions always *replace* previous ones
#
