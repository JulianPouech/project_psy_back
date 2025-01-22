<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface)
        {
            return;
        }

        $event->setData(["response" => "success"]);
        $cookie = Cookie::create('Authorization',
            $data['token'],
            sameSite: "strict",
            httpOnly:false,
    );
        $event->getResponse()->headers->setCookie($cookie);
    }
}
