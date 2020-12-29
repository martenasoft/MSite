<?php

namespace MartenaSoft\Site\Form;

use MartenaSoft\Common\Form\Type\StatusDropdownType;
use MartenaSoft\Media\Entity\MediaConfig;
use MartenaSoft\Media\Form\MediaSmallFormType;
use MartenaSoft\Media\Repository\MediaConfigRepository;
use MartenaSoft\Media\Repository\MediaRepository;
use MartenaSoft\Menu\Form\Type\MenuDropdownType;
use MartenaSoft\Menu\Service\SaveMenuItemService;
use MartenaSoft\Seo\Form\SeoSmallFormType;
use MartenaSoft\Site\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    private SaveMenuItemService $menuItemService;
    private MediaRepository $mediaRepository;
    private MediaConfigRepository $mediaConfigRepository;

    public function __construct(SaveMenuItemService $menuItemService,
        MediaRepository $mediaRepository,
        MediaConfigRepository $mediaConfigRepository
    ) {
        $this->menuItemService = $menuItemService;
        $this->mediaRepository = $mediaRepository;
        $this->mediaConfigRepository = $mediaConfigRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('status', StatusDropdownType::class)
            ->add('dateTime')
            ->add('preview')
            ->add('detail')

            ->add('seo', SeoSmallFormType::class, [
                'label' =>false,

            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                $mediaConfig = $this->mediaConfigRepository->getByName('article');

                if (!empty($mediaConfig)) {
                    $form->add('images', FileType::class, [
                        'mapped' => false,
                        'label' => false
                    ]);
                }

                if (empty($data->getId())) {
                    $form->add('menu', MenuDropdownType::class, [
                        'required' => false
                    ]);
                    $this->menuItemService->selectParentItemDropDown($event);
                }
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
