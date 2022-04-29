<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Choose an option' => '',
                    'Female' => 0,
                    'Male' => 1,
                    'Transgender' => 2
                ]
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('location')
            ->add('address')
            ->add('country')
            ->add('nationality')
            ->add('birthdate', TextType::class, [
                // 'widget' => 'single_text',
                // 'format' => 'yyyy-MM-dd'
            ])
            ->add('birthplace')
            ->add('picture', FileType::class, [
                'label' => 'Profile picture',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => ".pdf, .jpg, .doc, .docx, .png, .gif",
                ]
            ])
            ->add('passport', FileType::class, [
                'label' => 'passport img',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => ".pdf, .jpg, .doc, .docx, .png, .gif",
                ]
            ])
            ->add('cv', FileType::class, [
                'label' => 'cv (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => [
                    'Choose an option' => '',
                    '0 - 6 month' => '0 - 6 month',
                    '6 month - 1 year' => '6 month - 1 year',
                    '1 - 2 years' => '1 - 2 years',
                    '2+ years' => '2+ years',
                    '5+ years' => '5+ years',
                    '10+ years' => '10+ years'
                ]
            ])
            ->add('description')
            // ->add('disponibility')
            // ->add('email')
            // ->add('password')
            // ->add('roles')
            // ->add('file')
            // ->add('notes')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('isAdmin')
            ->add('categorie', EntityType::class, [
                'class' => "App\Entity\Categorie"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
