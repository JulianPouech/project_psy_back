<?php

namespace App\Trait;

use Symfony\Component\Form\FormInterface;

trait TraitErrorForm
{
    /**
     * @return array<string,array>
     */
    public function errorsFormToJson(FormInterface $form): array {
        $errors = [];

        foreach($form->getErrors(true) as $error)
        {
            array_push($errors,$error->getMessage());
        }

        return ["errors" => $errors];
    }
}
