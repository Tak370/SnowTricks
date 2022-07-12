<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire'
            ])
            ->add('trick', HiddenType::class)
            ->add('send', SubmitType::class, [
                    'label' => 'Envoyer'
                ]
            );

        $builder->get('trick')
            ->addModelTransformer(new CallbackTransformer(
                    fn(Trick $trick) => $trick->getId(),
                    fn(Trick $trick) => $trick->getName()
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'csrf_token_id' => 'comment-add'
        ]);
    }
}
