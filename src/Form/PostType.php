<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('dateOfCreation')*/
            ->add('description', TextType::class,[
                'label' => 'Описание'
            ])
            ->add('category', EntityType ::class, [
                'class' => 'App\Entity\Category',
                'label' => 'Категория'
            ])
            ->add('my_file', FileType::class, [
                'mapped' => false,
                'label' => 'Please upload file'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
