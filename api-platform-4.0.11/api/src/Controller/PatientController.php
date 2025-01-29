<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Security\JwtSecurity;
use App\Trait\ErrorFormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PatientController implements ControllerInterface
{
    use ErrorFormTrait;

    public function __construct(private PatientRepository $patientRepository,
        private FormFactoryInterface $formFactory,
        private JwtSecurity $jwtSecurity,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $patient = null;
        $currentUser = $this->jwtSecurity->getUser();

        if($this->jwtSecurity->isGranted('ROLE_ADMIN'))
        {
            $patient = $this->patientRepository->find(['id' => $id]);
        }else{
            $patient = $this->patientRepository->findByUserId($currentUser->getId(), $id);
        }

        if(!$patient instanceof Patient)
        {
            return new JsonResponse(status: 403);
        }

        $payload = json_decode(strip_tags($request->getContent()), true);
        $form = $this->formFactory->create(PatientType::class, $patient);
        $form->submit($payload);

        if(!$form->isValid())
        {
            return new JsonResponse($this->errorsFormToJson($form));
        }

        $this->patientRepository->update($patient);

        return new JsonResponse(status: 200);
    }

    public function create(Request $request): JsonResponse
    {
        $payload = json_decode(strip_tags($request->getContent()), true);

        $patient = new Patient();
        $form = $this->formFactory->create(PatientType::class, $patient);
        $form->submit($payload);

        if(!$form->isValid()){
            return new JsonResponse($this->errorsFormToJson($form));
        }

        $patient->addUser($this->jwtSecurity->getUser());
        $this->patientRepository->update($patient);

        return new JsonResponse(status: 200);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id): JsonResponse
    {
        /** @var Patient */
        $patient = $this->patientRepository->findOneBy(['id' => $id]);
        $patient->setFirstName('firstName'.$patient->getId());
        $patient->setLastName('lastName'.$patient->getId());
        $patient->setPhone('');

        foreach($patient->getUsers() as $user)
        {
            $user->removePatient($patient);
            $this->entityManager->persist($user);
        };

        $patient->clearUsers();
        $this->patientRepository->update($patient);

        return new JsonResponse(status: 200);
    }

    public function index(Request $request): JsonResponse
    {
        $patients = [];
        $currentUser = $this->jwtSecurity->getUser();
        if(!$this->jwtSecurity->isGranted('ROLE_ADMIN', $currentUser))
        {
            foreach($currentUser->getPatients() as $patient)
            {
                array_push($patients,$patient->getVisible());
            }

            return new JsonResponse(['patients' => $patients]);
        }

        $payload = json_decode(strip_tags($request->getContent()), true);

        if(isset($payload['filter']))
        {
            $patients = $this->patientRepository->findByFilter($payload['filter']);

            return new JsonResponse(['patients' => $patients]);
        }

        $patients = $this->patientRepository->getAll($payload['pages']??0);


        return new JsonResponse(['patients' => $patients],status: 200);
    }


    public function select(int $id): JsonResponse
    {
        $currentUser = $this->jwtSecurity->getUser();
        $patient = null;

        if($this->jwtSecurity->isGranted('ROLE_ADMIN', $currentUser))
        {
            /** @var ?Patient */
            $patient = $this->patientRepository->findOneBy(['id' => $id]);
            return new JsonResponse(['patient' => $patient->getVisible()]);
        }

        /** @var ?Patient */
        $patient = $this->patientRepository->findByUserId($currentUser->getId(), $id);

        if(!$patient instanceof Patient)
        {
            return new JsonResponse(status: 403);
        }

        return new JsonResponse(['patient' => $patient->getVisible()]);
    }
}
