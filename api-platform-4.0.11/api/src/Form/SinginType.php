<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SinginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', TextType::class, [
            'constraints' => [
                new Email(message:"email:email n'est pas bon"),
                ]
            ])->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_name' => "password",
                'second_name' => "repeatPassword",
                'invalid_message' => "password: le mot de pass ne sont pas le meme",
                'constraints' => [
                    new NotBlank(message: 'password:vieullier saisire un mot de pass'),
                ]
            ])->add('address',AddressType::class)
        ;
    }
}
