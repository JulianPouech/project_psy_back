<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Security\JwtSecurity;
use App\Trait\TraitErrorForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PatientController implements ControllerInterface
{
    use TraitErrorForm;

    public function __construct(private PatientRepository $patientRepository,
        private FormFactoryInterface $formFactory,
        private JwtSecurity $jwtSecurity
    ) {
    }

    public function update(Request $request, int $id): JsonResponse
    {
        /** @var ?Patient*/
        $patient = $this->patientRepository->findOneBy(["id" => $id]);
        $currentUser = $this->jwtSecurity->getUser();

        $payload = json_decode(strip_tags($request->getContent()), true);

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

        return new JsonResponse(status: 200);
    }

    public function delete(int $id): JsonResponse
    {

        return new JsonResponse(status: 200);
    }

    public function index(Request $request): JsonResponse
    {
        $payload = json_decode(strip_tags($request->getContent()), true);
        $patients = [];
        if(isset($payload['filter']))
        {
            $patients = $this->patientRepository->findBy([
                'last_name' => $payload['filter']['lastName'],
                'first_name' => $payload['filter']['firstName']
            ]);

            return new JsonResponse(['patients' => $patients]);
        }
        $patients = $this->patientRepository->findAll();

        return new JsonResponse(['patients' => $patients],status: 200);
    }


    public function select(int $id): JsonResponse
    {

        return new JsonResponse(status: 200);
    }
}
