<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Security\JwtSecurity;
use App\Trait\ErrorFormTrait;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddressController implements ControllerInterface
{
    public function __construct(
        private AddressRepository $addressRepository,
        private FormFactoryInterface $formFactory,
        private JwtSecurity $jwtSecurity

    ) {
    }

    use ErrorFormTrait;

    public function update(Request $request,int $id): JsonResponse
    {
        $user = $this->jwtSecurity->getUser();

        if(!$this->jwtSecurity->isGranted('ROLE_ADMIN',$user) && $user?->getAddress()?->getId() !== $id)
        {
            return new JsonResponse(status: 403);
        }

        $address = $this->addressRepository->find(id: $id);

        if(!$address instanceof Address)
        {
            return new JsonResponse(status: 404);
        }

        $payload = json_decode(strip_tags($request->getContent()), true);
        $form = $this->formFactory->createBuilder(AddressType::class,$address)->getForm();
        $form->submit($payload);

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
        return new JsonResponse(status: 200);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): JsonResponse
    {
        $payload = json_decode(strip_tags($request->getContent()), true);
        $address = new Address();
        $from = $this->formFactory->create(AddressType::class, $address);
        $from->submit($payload);

        if(!$from->isValid())
        {
            return new JsonResponse($this->errorsFormToJson($from));
        }

        $this->addressRepository->update($address);

        return new JsonResponse(['response' => 'ok'],status:201);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id): JsonResponse
    {
        $address = $this->addressRepository->findOneBy(['id' => $id]);

        if(!$address instanceof Address)
        {
            return new JsonResponse(status: 404);
        }

        $address->setAddress('address'.$address->getId());
        $address->setCity('city'.$address->getId());
        $address->setCountry('');
        $address->setPostalCode('postalCode'.$address->getId());
        $this->addressRepository->update($address);

        return new JsonResponse();
    }

    public function index(Request $request): JsonResponse
    {
        $payload = json_decode(strip_tags($request->getContent()), true);
        $currentUser = $this->jwtSecurity->getUser();

        if($this->jwtSecurity->isGranted('ROLE_ADMIN', $currentUser))
        {
            $address = $this->addressRepository->getAll($payload['pages']??0);
            return new JsonResponse(['address' => $address]);
        }


        return new JsonResponse(['address' => $currentUser?->getAddress()?->getVisible()]);
    }

    public function select(int $id): JsonResponse
    {
        $currentUser = $this->jwtSecurity->getUser();

        if(!$this->jwtSecurity->isGranted('ROLE_ADMIN', $currentUser)&& $currentUser?->getAddress()?->getId() !== $id)
        {
            return new JsonResponse(status:403);
        }

        $address = $this->addressRepository->findOneBy(['id' => $id]);

        if(!$address instanceof Address)
        {
            return new JsonResponse(status: 404);
        }

        return new JsonResponse(['address' => $address->getVisible()]);
    }


}
