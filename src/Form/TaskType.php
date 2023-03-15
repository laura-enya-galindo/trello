<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
// use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            # Le titre est un champs obligatoire
            ->add('title', TextType::class, [
                'invalid_message' => "Le titre {{ value }} n'est pas un texte valide",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer un titre',
                    ]),
                ],
            ])
            // ])
            ->add('content', TextareaType::class, [
                'invalid_message' => "Le contenu n'est pas un texte valide",
            ])
            # La date de création est un champs obligatoire
            ->add('created_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                // 'format' => IntlDateFormatter::SHORT,
            ])
            ->add('updated_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                // 'format' => IntlDateFormatter::RELATIVE_SHORT,
            ])
            ->add('completed_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                // 'format' => IntlDateFormatter::SHORT,
            ])
            ->add('users', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                # TO-DO : traiter le cas des homonymes
                // uses the User.last_name property as the visible option string
                'choice_label' => 'last_name',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Nouveau' => 'nouveau',
                    'En cours' => 'en_cours',
                    'Traité' => 'traite',
                ],
                # Le ticket a le statut "Nouveau" par défaut
                'empty_data' => 'Nouveau',
            ])
            # comment enregistrer l'input de l'utilisateur dans les données de l'entité "Statut" en BDD ? est-ce qu'il faut le faire ? où le coder alors ?
            # ou alors mettre EntityType et mettre les trois options en données pour l'entité "Statut" ?
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
