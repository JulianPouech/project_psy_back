<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\SinginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository,
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
}
