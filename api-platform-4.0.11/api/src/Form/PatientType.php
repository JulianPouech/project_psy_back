<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('lastName', TextType::class, [
                'constraints' => [
                    new Regex(pattern: '\^[A-Z][a-z]{1,}$\g', message: '{{ label }}:2'),
                    new NotBlank(message: '{{ label }}:1'),
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Regex(pattern: '\^[A-Z][a-z]{1,}$\g', message: '{{ label }}:2'),
                    new NotBlank(message: '{{ label }}:1'),
                ]
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new Regex(pattern: '/^[0-9]{10,12}$/g', message: '{{ label }}:2'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class
        ]);
    }
}
