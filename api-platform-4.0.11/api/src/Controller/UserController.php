<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\SinginType;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository,
        private TokenStorageInterface $tokenStorage,
        private JWTTokenManagerInterface $jWTTokenManager
    ) {
    }
    public function create(Request $request):JsonResponse {
        $body = json_decode(strip_tags($request->getContent()), true);
        $user = new User();
        $form  = $this->formFactory->createBuilder(SinginType::class,$user)->getForm();
        $form->submit($body);

        if(!$form->isValid())
        {
            $errors = [];
            foreach($form->getErrors(true) as $error)
            {
               array_push($errors,$error->getMessage());
            }

            return new JsonResponse(['errors' => $errors]);
        }

        $this->userRepository->create($user);

        return new JsonResponse(["response" => "ok"]);
    }

    public function get(): void {
        $decodedJwtToken = $this->jWTTokenManager->decode($this->tokenStorage->getToken());
        dd($decodedJwtToken);
    }
}
