<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
// use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            # Le titre est un champs obligatoire
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer un titre',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le titre ne peut pas contenir plus de {{ limit }} caractères',
                    ]),
                'invalid_message' => "Le titre {{ value }} n'est pas un texte valide",
            ]])
            ->add('content', TextareaType::class, [
                'invalid_message' => "Le contenu n'est pas un texte valide",
            ])
            # La date de création est un champs obligatoire
            ->add('created_at', DateType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer une date de création du ticket',
                    ]),
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'input_format' => 'd-m-Y',
                # TO-DO: remove if it's not useful
                'placeholder' => [
                    'year' => 'YYYY', 'month' => 'mm', 'day' => 'dd',
                ],
                // 'format' => IntlDateFormatter::SHORT,
            ]])
            ->add('updated_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'input_format' => 'd-m-Y',
                // 'format' => IntlDateFormatter::RELATIVE_SHORT,
            ])
            ->add('completed_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'input_format' => 'd-m-Y',
                // 'format' => IntlDateFormatter::SHORT,
            ])
            ->add('users', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                // uses the User.last_name property as the visible option string
                'choice_label' => 'last_name',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,

                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez assigner ce ticket à au moins un utilisateur',
                    ]),
                ]
            ]);

            ->add('status', ChoiceType::class, [
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
