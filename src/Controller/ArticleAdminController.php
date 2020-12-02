<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Event\CommonFormBeforeSaveEvent;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Event\SaveMenuEvent;
use MartenaSoft\Menu\Event\SaveMenuEventInterface;
use MartenaSoft\Menu\Service\SaveMenuItemServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticleAdminController extends AbstractCrudController
{
    private SaveMenuItemServiceInterface $saveMenuItemService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        EventDispatcherInterface $eventDispatcher,
        SaveMenuItemServiceInterface $saveMenuItemService
    ) {
        parent::__construct($entityManager, $logger, $eventDispatcher);
        $this->saveMenuItemService  = $saveMenuItemService;
    }

    protected function initListener(): void
    {
        $this
            ->getEventDispatcher()
            ->addListener(CommonFormBeforeSaveEvent::getEventName(), function (CommonFormBeforeSaveEvent $event) {
                $formData = $event->getForm()->getData();
                $menuData = $formData->getMenu();
                $menu = null;
                if ($formData->getId() === null) {
                    $menu = new Menu();
                    $menu->setName($formData->getName());
                } else {

                }
                $this->saveMenuItemService->save($menuData, $menu);
            });
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