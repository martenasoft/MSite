<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Controller\AbstractAdminCommonInitController;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Event\SaveMenuEvent;
use MartenaSoft\Menu\Event\SaveMenuEventInterface;
use MartenaSoft\Menu\Service\SaveMenuItemServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticleAdminController extends AbstractAdminCommonInitController
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
            ->addListener(SaveMenuEvent::getEventName(), function (SaveMenuEventInterface $event) {

                $menu = $this->saveMenuItemService->getMenuByName($event->getEntity()->getName());
                if ($event->getEntity()->getId() === null || $menu === null) {
                    $menu = new Menu();
                    $menu->setName($event->getEntity()->getName());
                   // $menuRepository = $this->get(SaveMenuItemServiceInterface::class);
                } else {

                }
                $this->saveMenuItemService->save($menu, $event->getMenu());
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
