<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Event\CommonEventInterface;
use MartenaSoft\Common\Event\CommonFormBeforeSaveEvent;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Crud\Event\CrudBeforeSaveEvent;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Service\SaveMenuItemServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticleAdminController extends AbstractCrudController
{
    private SaveMenuItemServiceInterface $menuRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        EventDispatcherInterface $eventDispatcher,
        SaveMenuItemServiceInterface $menuRepository
    ) {
        parent::__construct($entityManager, $logger, $eventDispatcher);
        $this->menuRepository = $menuRepository;
    }

    protected function initListener(): void
    {
        $this->getEventDispatcher()
            ->addListener(
                CrudBeforeSaveEvent::getEventName(), function (CommonEventInterface $event) {

                $formData = $event->getForm()->getData();
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
