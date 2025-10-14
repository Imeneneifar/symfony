<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('id', TextType::class, ['label' => 'Référence ',])

            ->add('title', TextType::class, ['label' => 'Titre'])

            // ← ICI: le champ "category" existe bien dans le form
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'placeholder' => '- choisir -',
                'choices' => [
                    'Roman' => 'Roman',
                    'Science' => 'Science',
                    'Histoire' => 'Histoire',
                    'Informatique' => 'Informatique',
                ],
            ])
            // (si tu préfères texte libre: TextType::class à la place de ChoiceType)

            ->add('publicationDate', DateType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text',
            ])
            ->add('author1', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Auteur',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Book::class]);
    }
}
