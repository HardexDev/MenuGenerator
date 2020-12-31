<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Aliment;
use App\Entity\Dessert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GenerationParametersType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dishes = $this->entityManager->getRepository(Dish::class)->findAll();
        $desserts = $this->entityManager->getRepository(Dessert::class)->findAll();
        $builder
            ->add('nb_meat', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_egg', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_fish', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_vegetable', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_starchy', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_yogurt', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_fruit', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_cheese', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('nb_greedy', ChoiceType::class, [
                'choices' => [
                    'Choisir la quantité' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('remove_dish', EntityType::class, [
                'class' => Dish::class,
                'placeholder' => 'Plat à supprimer',
                'choice_label' => 'dishname',
                'required' => false,
            ])
            ->add('remove_dessert', EntityType::class, [
                'class' => Dessert::class,
                'placeholder' => 'Dessert à supprimer',
                'choice_label' => 'dessertname',
                'required' => false,
            ])
            ->add('force_aliment', EntityType::class, [
                'class' => Aliment::class,
                'placeholder' => 'Aliment à imposer',
                'choice_label' => 'alimentname',
                'required' => false,
            ])
            ->add('jour_semaine', ChoiceType::class, [
                'choices' => [
                    'Choisir le jour de départ' => null,
                    'Lundi' => 'Monday',
                    'Mardi' => 'Tuesday',
                    'Mercredi' => 'Wednesday',
                    'Jeudi' => 'Thursday',
                    'Vendredi' => 'Friday',
                    'Samedi' => 'Saturday',
                    'Dimanche' => 'Sunday',
                ],
                'required' => false,
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
