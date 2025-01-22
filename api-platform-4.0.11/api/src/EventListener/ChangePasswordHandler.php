<?php

namespace App\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ChangePasswordHandler
{
    public function __invoke(FormEvent $formEvent)
    {
        $data = $formEvent->getData();
        $plainPassword = $data['plainPassword'];
        foreach($plainPassword as $filds){
            if($filds === $data['oldPassword'])
            {

                $formEvent->stopPropagation();
                return true;
            }
        }
        return false;
    }
}
