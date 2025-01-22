<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('address', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: '{{ label }}:app_address_blank'),
                    new Regex(pattern: '/^[0-9-]{1,} [a-zA-z]/', message: '{{ label }}:app_address_pattern')
                ]
            ])->add('city', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: '{{ label }}:app_city_blank'),
                    new Regex('/^[A-z]{1,}/',message: "{{ label }}:app_city_pattern")
                ],
            ])->add('country', TextType::class, [
                'constraints' => [
                    new Country(message: '{{ label }}:app_country_not_country'),
                ]
            ])->add('postalCode', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: '{{ label }}:app_postal_code_blank'),
                    new Regex('/^[A-z0-9]{1,}/',message: "{{ label }}:app_postal_code_pattern")
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }

}
