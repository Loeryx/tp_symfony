<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'USER_ROLE',
                    'Banned' => 'BANNED_ROLE',
                    'Admin' => 'ADMIN_ROLE',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Roles',
                'mapped' => false,
                'data' => isset($options['data']) && isset($options['data']->getRoles()[0])
                    ? $options['data']->getRoles()[0]
                    : 'ROLE_USER',
            ])
            ->add('password')
            ->add('name')
            ->add('lastName')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
