<?php

namespace App\Controller;

use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Security\JwtSecurity;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddressController implements ControllerInterface
{
    public function __construct(
        private AddressRepository $addressRepository,
        private FormFactoryInterface $formFactory,
        private JwtSecurity $jwtSecurity

    ) {
    }


    public function update(Request $request,int $id): JsonResponse
    {
        $user = $this->jwtSecurity->getUser();
        if(!$this->jwtSecurity->isGranted('ROLE_ADMIN',$user) && $user->getAddress()->getId() !== $id)
        {
            return new JsonResponse(status: 403);
        }

        $body = json_decode(strip_tags($request->getContent()), true);
        $address = $this->addressRepository->find(id: $id);
        $form = $this->formFactory->createBuilder(AddressType::class,$address)->getForm();
        $form->submit($body);

        if(!$form->isValid())
        {
            $errors = [];
            foreach($form->getErrors(true) as $error)
            {
               array_push($errors,$error->getMessage());
            }

            return new JsonResponse(['errors' => $errors], status:406);
        }

        $this->addressRepository->update($address);
        return new JsonResponse(['response' => "app_address_update"]);
    }

    public function create(Request $request): JsonResponse
    {
        return new JsonResponse(['response' => 'ok']);
    }

    public function delete(int $id): JsonResponse
    {
        if($this->jwtSecurity->isGranted('ROLE_ADMIN'))
        {
            return new JsonResponse(status: 403);
        };

    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse(['response' => 'ok']);
    }

    public function select(int $id): JsonResponse
    {
        return new JsonResponse(['response' => 'ok']);
    }

}
