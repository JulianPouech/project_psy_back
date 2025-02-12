<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastName', TextType::class, [
                'constraints' => [
                    new Regex(pattern: '/^[A-Z][a-z]{1,}$/', message: '{{ label }}:2'),
                    new NotBlank(message: '{{ label }}:1'),
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Regex(pattern: '/^[A-Z][a-z]{1,}$/', message: '{{ label }}:2'),
                    new NotBlank(message: '{{ label }}:1'),
                ]
            ])->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(message: '{{ label }}:1'),
                    new Email(message: '{{ label }}:2'),
                ]
            ])->add('message', TextType::class, [
                'constraints' => [
                    new NotBlank(message: '{{ label }}:1')
                ]
            ])->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank(message: '{{ label }}:1'),
                    new Regex(pattern: '/^[0-9]{10,12}$/', message: '{{ label }}:2'),
                ]
            ])
        ;
    }
}
