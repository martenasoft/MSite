<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Event\CommonFormBeforeSaveEvent;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Crud\Event\CrudBeforeSaveEvent;
use MartenaSoft\Menu\Service\SaveMenuItemServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class ArticleAdminController extends AbstractCrudController
{
    private SaveMenuItemServiceInterface $saveMenuItemService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        EventDispatcherInterface $eventDispatcher,
        SaveMenuItemServiceInterface $saveMenuItemService
    ) {
        $this->saveMenuItemService  = $saveMenuItemService;
        parent::__construct($entityManager, $logger, $eventDispatcher);
    }

    protected function initListener(): void
    {
        $this->saveMenuItemService->initSaveMenuListener('menu_id', CrudBeforeSaveEvent::getEventName());
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
