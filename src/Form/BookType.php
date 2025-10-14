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
        
            ->add('id', TextType::class, ['label' => 'Reference ',])

            ->add('title', TextType::class, ['label' => 'Title'])

            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'placeholder' => '- - -',
                'choices' => [
                    'Novel' => 'Novel',
                    'Science' => 'Science',
                    'History' => 'History',
                    'Computer Science' => 'Computer Science',

                ],
            ])

            ->add('publicationDate', DateType::class, [
                'label' => 'Publication Date',
                'widget' => 'single_text',
            ])
            ->add('author1', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Author',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Book::class]);
    }
}
