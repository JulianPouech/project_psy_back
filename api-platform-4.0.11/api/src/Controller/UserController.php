<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\SinginType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\JwtSecurity;
use App\Trait\ErrorFormTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController implements ControllerInterface
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository,
        private TokenStorageInterface $tokenStorage,
        private JWTTokenManagerInterface $jWTTokenManager,
        private JwtSecurity $jwtSecurity,
    ) {
    }
    use ErrorFormTrait;

    public function create(Request $request):JsonResponse {
        $payload = json_decode(strip_tags($request->getContent()), true);
        $user = new User();
        $form  = $this->formFactory->create(SinginType::class,$user);
        $form->submit($payload);

        if(!$form->isValid())
        {
            $errors = [];
            foreach($form->getErrors(true) as $error)
            {
               array_push($errors,$error->getMessage());
            }

            return new JsonResponse($this->errorsFormToJson($form),status: 406);
        }

        $this->userRepository->create($user);

        return new JsonResponse(["response" => "created"], status: 201);
    }

    public function select(int $id): JsonResponse {

        $user = $this->jwtSecurity->getUser();

        return new JsonResponse($user->getVisible());
    }

    public function update(Request $request, int $id): JsonResponse {
        $user = $this->jwtSecurity->getUser();

        if($user->getId() !== $id)
        {
            return new JsonResponse(status:403);
        }

        $payload = json_decode(strip_tags($request->getContent()), true);

        if(isset($payload['changePassword']))
        {
            return $this->updatePassword($user,$payload['changePassword']);
        } else if (!isset($payload['email'])){
            return new JsonResponse(['errors' => 'app_error_update_user']);
        }

        $form = $this->formFactory->create(UserType::class, $user);
        $form->submit($payload);

        if(!$form->isValid())
        {
            return new JsonResponse($this->errorsFormToJson($form), status:406);
        }

        $this->userRepository->upgradeUser($user);

        return new JsonResponse(['response' => 'ok']);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id): JsonResponse
    {

        return new JsonResponse(['response' => 'ok']);
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse(['response' => 'ok']);
    }

    private function updatePassword(User $user, Array $data): JsonResponse {
        $form = $this->formFactory->create(ChangePasswordType::class,$user);
        $form->submit($data);
        $errors = [];


        if(!$form->isValid())
        {
            return new JsonResponse($this->errorsFormToJson($form), status:406);
        }

        if($user->getOldPassword() === $user->getPlainPassword())
        {
            array_push($errors,'app_plain_password_same_old');

            return new JsonResponse($errors, status:406);
        }

        $hasedPassword = $this->userPasswordHasher->hashPassword($user,$user->getPlainPassword());
        $this->userRepository->upgradePassword($user,$hasedPassword);
        return new JsonResponse(['response'=>'password update']);
    }
}
