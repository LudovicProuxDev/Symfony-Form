<?php

namespace App\Form;

use App\Entity\Formtest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class FormtestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'help' => 'Input a name',
                'required' => false,
            ])
            ->add('kilometers', NumberType::class, [
                'help' => 'Input a number ok kilometers between 1 and 1000',
                'required' => false,
                'scale' => 0,
            ])
            ->add('price', NumberType::class, [
                'help' => 'Input a price between 0.01 and 999.99',
                'required' => false,
                'scale' => 2,
            ])
            ->add('creation', DateTimeType::class, [
                'widget' => 'single_text',
                'help' => 'Select a datetime',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'help' => 'Input an email',
                'required' => false,
            ])
            ->add('categories', ChoiceType::class, [
                'choices'  => [
                    'Sport' => 'sport',
                    'Art' => 'art',
                    'Music' => 'music',
                    'Biology' => 'biology',
                    'Games' => 'games',
                ],
                'expanded' => false,
                'help' => 'Select 1 or 2 categories',
                'multiple' => true,
                'required' => false,
            ])
            ->add('phonenumber', TelType::class, [
                'help' => 'Input a French phone number, including 0 at first',
                'required' => false,
            ])
            ->add('good', CheckboxType::class, [
                'help' => 'Check if it is good',
                'required' => false,
            ])
            ->add('season', ChoiceType::class, [
                'choices' => [
                    'Summer' => 'SUMMER',
                    'Autumn' => 'AUTUMN',
                    'Winter' => 'WINTER',
                    'Spring' => 'SPRING',
                ],
                'expanded' => true,
                'help' => 'Select 1 season',
                'multiple' => false,
                'required' => false,
            ])
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Red' => 'RED',
                    'Blue' => 'BLUE',
                    'Green' => 'GREEN',
                ],
                'expanded' => false,
                'help' => 'Select 1 color',
                'multiple' => false,
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'empty_data' => !null,
                'help' => 'Select a JPEG or PNG file',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG document',
                    ])
                ],
            ])
            ->add('pdf', FileType::class, [
                'empty_data' => !null,
                'help' => 'Select a PDF file',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formtest::class,
        ]);
    }
}
