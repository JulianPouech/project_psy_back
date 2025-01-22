<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;

final class JwtSecurity
{

    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function isGranted(string $roleName,?User $user = null): bool{

        if(!$user instanceof User)
        {
            $user = $this->userRepository->findOneByJwt();
        }

        return array_search($roleName, $user->getRoles()) === $roleName;
    }

    public function getUser(): User {
        return $this->userRepository->findOneByJwt();
    }
}
