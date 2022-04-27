<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender')
            ->add('firstName')
            ->add('lastName')
            ->add('location')
            ->add('address')
            ->add('country')
            ->add('nationality')
            ->add('birthdate')
            ->add('birthplace')
            ->add('picture')
            ->add('passport')
            ->add('cv')
            ->add('experience')
            ->add('description')
            ->add('disponibility')
            ->add('email')
            ->add('password')
            ->add('roles')
            ->add('file')
            ->add('notes')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('isAdmin')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
