<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedListener
{
    public function __construct(private UserRepository $userRepository) {
    }
    public function onCreatedJwt(JWTCreatedEvent $event): void {
        $payload = $event->getData();
        $user = $this->userRepository->findOneByEmail($payload['username']);

        if(!$user instanceof User)
        {
            return;
        }

        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}
