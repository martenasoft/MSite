<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Event\CommonEventInterface;
use MartenaSoft\Common\Event\CommonFormBeforeSaveEvent;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Crud\Event\CrudAfterSaveEvent;
use MartenaSoft\Crud\Event\CrudBeforeSaveEvent;
use MartenaSoft\Media\Repository\MediaConfigRepository;
use MartenaSoft\Media\Service\UploadImageService;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Service\SaveMenuItemServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticleAdminController extends AbstractCrudController
{
    private SaveMenuItemServiceInterface $menuRepository;
    private MediaConfigRepository $mediaConfigRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        EventDispatcherInterface $eventDispatcher,
        SaveMenuItemServiceInterface $menuRepository,
        UploadImageService $uploadImageService,
        MediaConfigRepository $mediaConfigRepository
    ) {
        parent::__construct($entityManager, $logger, $eventDispatcher);
        $this->menuRepository = $menuRepository;
        $this->uploadImageService = $uploadImageService;
        $this->mediaConfigRepository = $mediaConfigRepository;
    }

    protected function initListener(): void
    {
        $this->getEventDispatcher()
            ->addListener(
                CrudBeforeSaveEvent::getEventName(), function (CommonEventInterface $event) {

                $formData = $event->getForm()->getData();
                $name = $formData->getName();
                $event->getEntity()->getSeo()->setName($formData->getName());

                if (!empty($formData->getId())) {
                    return;
                }

                $menuData = $formData->getMenu();
                $menu = new Menu();
                $menu->setName($formData->getName());
                $menu->setUrl($formData->getName());

                try {
                    $this->menuRepository->save($menu, $menuData);
                    $event->getForm()->getData()->setMenu($menu);
                } catch (\Throwable $exception) {
                    throw $exception;
                }
            });

        $this->getEventDispatcher()
            ->addListener(CrudAfterSaveEvent::getEventName(), function(CommonEventInterface $event) {
                $entity = $event->getEntity();
                $form = $event->getForm();

                $mediaConfig = $this->mediaConfigRepository->getByName('article');
                $this->uploadImageService->upload($form->get('images')->getData(), $mediaConfig);
            });
    }


    protected function getSaveTemplate(): string
    {
        return '@MartenaSoftSite/article/save.html.twig';
    }

    protected function getH1(): string
    {
        return 'Article';
    }

    protected function getTitle(): string
    {
        return 'Article';
    }

    protected function itemsFields(): array
    {
        return ['name'];
    }
}
