<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du trick',
                'empty_data' => ''
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'empty_data' => ''
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class
            ])
            ->add('featuredText', TextType::class, [
                'label' => 'Text à la une',
                'empty_data' => ''
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'empty_data' => ''
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image à la une'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
