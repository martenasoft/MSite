<?php

namespace MartenaSoft\Site\Form;

use MartenaSoft\Common\Form\Type\StatusDropdownType;
use MartenaSoft\Menu\Form\Type\MenuDropdownType;
use MartenaSoft\Menu\Service\SaveMenuItemService;
use MartenaSoft\Site\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    private SaveMenuItemService $menuItemService;

    public function __construct(SaveMenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('status', StatusDropdownType::class)
            ->add('dateTime')
            ->add('preview')
            ->add('detail')
            ->add('menu', MenuDropdownType::class, [
                'required' => false
            ])->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $this->menuItemService->selectParentItemDropDown($event);
            });
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

