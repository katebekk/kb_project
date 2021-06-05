<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('dateOfCreation')*/
            ->add('description', TextType::class,[
                'label' => 'Описание',
                'required' => false
            ])
            ->add('category', EntityType ::class, [
                'class' => 'App\Entity\Category',
                'label' => 'Категория',
                 'attr' => ['class' => 'custom-select']
            ])
            ->add('my_file', FileType::class, [
                'mapped' => false,
                'label' => 'Загрузите фотографию',
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/PNG',

                        ],
                        'mimeTypesMessage' => 'Пожалуйста выберете файл с расшернием png или jpeg',
                    ])
                ],
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
