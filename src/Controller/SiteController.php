<?php

namespace MartenaSoft\Site\Controller;

use MartenaSoft\Common\Entity\PageDataInterface;
use MartenaSoft\Common\Event\LoadConfigEvent;
use MartenaSoft\Common\Service\ConfigService\CommonConfigServiceInterface;
use MartenaSoft\Content\Controller\AbstractContentController;
use MartenaSoft\Content\Controller\CommonEntityInterface;

use MartenaSoft\Content\Entity\ConfigInterface;
use MartenaSoft\Content\Service\ParserUrlService;
use MartenaSoft\Menu\Entity\MenuInterface;
use MartenaSoft\Menu\Repository\MenuRepository;
use MartenaSoft\Site\Entity\SiteConfig;
use MartenaSoft\Site\MartenaSoftSiteBundle;
use MartenaSoft\Site\Repository\ArticleRepository;
use MartenaSoft\Site\Repository\SiteConfigRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractContentController
{
    public const ROOT_NODE_NAME = 'article';
    private SiteConfigRepository $configRepository;
    private CommonConfigServiceInterface $commonConfigService;
    private ArticleRepository $articleRepository;

    public function __construct(
        ParserUrlService $parserUrlService,
        MenuRepository $menuRepository,
        SiteConfigRepository $configRepository,
        EventDispatcherInterface $eventDispatcher,
        CommonConfigServiceInterface $commonConfigService,
        ArticleRepository $articleRepository
    ) {
        parent::__construct($parserUrlService, $menuRepository);
        $this->configRepository = $configRepository;
        $this->commonConfigService = $commonConfigService;

        $eventDispatcher->dispatch(
            new LoadConfigEvent(SiteConfig::class),
            LoadConfigEvent::getEventName()
        );

        $this->articleRepository = $articleRepository;
    }

    public function index(): Response
    {
        return $this->render('@MartenaSoftSite/site/index.html.twig');
    }

    public function previewInMain(): Response
    {
        $queryBuilder = $this
            ->articleRepository
            ->getItemQueryBuilder()
            ->setFirstResult(0)
            ->setMaxResults(10)
        ;

        $queryBuilder
            ->andWhere(ArticleRepository::getAlias().".dateTime<=:now")
            ->setParameter("now", new \DateTime('now'))
        ;

        return $this->render('@MartenaSoftSite/article/preview_in_main.html.twig', [
            'items' => $queryBuilder->getQuery()->getResult()
        ]);
    }

    protected function getResponse(PageDataInterface $pageData): Response
    {
        return $this->render('@MartenaSoftSite/site/page.html.twig', [
            'pageData' => $pageData
        ]);
    }

    protected function getRootMenuEntity(): ?MenuInterface
    {
        return $this
             ->menuRepository
             ->findOneByNameQueryBuilder(self::ROOT_NODE_NAME)
             ->getQuery()
             ->getOneOrNullResult();
    }

    protected function getConfig(string $url): ?ConfigInterface
    {
        $configData = $this->commonConfigService->get(MartenaSoftSiteBundle::getConfigName());
        return $this->commonConfigService->array2ConfigEntity($configData, new SiteConfig());
    }
}
