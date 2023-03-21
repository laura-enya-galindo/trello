<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;

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
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('updated_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('completed_at', DateType::class, [
                'invalid_message' => "La date {{ value }} n'est pas une date valide",
                'widget' => 'choice',
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('users', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                'choice_label' => function (User $users) {
                    return substr($users->getFirstName(), 0, 1) . '. ' . $users->getLastName() . ' ' . $users->getId();
                },
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'label',
                'multiple' => false,
                'expanded' => false,
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
