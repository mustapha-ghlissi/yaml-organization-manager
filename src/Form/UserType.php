<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Name',
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Role',
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    'ADMIN' => 'ADMIN',
                    'CEO' => 'CEO',
                    'SALES' => 'SALES',
                    'MANAGER' => 'MANAGER'
                ]
            ])
            ->add('password', null, [
                'label' => 'Password',
                'attr' => [
                    'rows' => 12
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
