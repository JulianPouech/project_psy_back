<?php

namespace App\Form;

use App\Entity\User;
use App\EventListener\ChangePasswordHandler;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\Match_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

class ChangePasswordType extends AbstractType
{
    private ?string $oldPassword = null;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('oldPassword',type: PasswordType::class,options: [
            'constraints' =>[
                new UserPassword(message: "{{ label }}:app_password_same"),
                new NotBlank(message: '{{ label }}:app_password_blank')
            ]
        ]
        )
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_name' => "password",
                'second_name' => "repeatPassword",
                'invalid_message' => "app_password_same",
                'constraints' => [
                    new NotBlank(message: '{{ label }}:app_password_blank'),
                ]
            ])//->addEventListener(FormEvents::PRE_SUBMIT,new ChangePasswordHandler())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
