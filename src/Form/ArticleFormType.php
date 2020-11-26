<?php

namespace MartenaSoft\Site\Form;

use MartenaSoft\Common\Form\Type\StatusDropdownType;
use MartenaSoft\Menu\Form\Type\MenuDropdownType;
use MartenaSoft\Site\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('status', StatusDropdownType::class)
            ->add('dateTime')
            ->add('preview')
            ->add('detail')
            ->add('menu', MenuDropdownType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Article::class
            ]
        );
    }
}

