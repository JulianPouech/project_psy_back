<?php

namespace App\Controller;

use App\Event\ContactEvent as AppContactEvent;
use App\Form\ContactType;
use App\Model\Contact;
use App\Trait\ErrorFormTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController
{
    use ErrorFormTrait;

    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private FormFactoryInterface $formFactory
    ) {
    }
    public function contact(Request $request): JsonResponse {
        $payload = json_decode(strip_tags($request->getContent()), true);
        $contact = new Contact();
        $form = $this->formFactory->create(ContactType::class, $contact);
        $form->submit($payload);

        if(!$form->isValid())
        {
            return new JsonResponse($this->errorsFormToJson($form),400);
        }
        $contactEvent = new AppContactEvent($contact);
        dump($contactEvent);
        $this->eventDispatcher->dispatch($contactEvent,'onContact');

        return new JsonResponse(status: 200);
    }
}
