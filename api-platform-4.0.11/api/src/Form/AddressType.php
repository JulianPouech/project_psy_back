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
                    new NotBlank(message: 'address:vieullier une address'),
                    new Regex(pattern: '/^[0-9-]{1,} [a-zA-z]/', message: 'address:vieullier rentre une address valide')
                ]
            ])->add('city', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'city:vieullier saisire un nom de ville'),
                    new Regex('/^[A-z]{1,}/',message: "city:ce n'est pas un nom correct")
                ],
            ])->add('country', TextType::class, [
                'constraints' => [
                    new Country(message: 'country:le nom du pays nes pas bon'),
                ]
            ])->add('postalCode', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'postalCode:vieullier saisire un code postal'),
                    new Regex('/^[A-z0-9]{1,}/',message: "postalCode:le code postal n'est pas bon")
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
