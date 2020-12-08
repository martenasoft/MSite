<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\QueryBuilder;
use MartenaSoft\Common\Entity\PageDataInterface;
use MartenaSoft\Common\Event\LoadConfigEvent;
use MartenaSoft\Common\Service\ConfigService\CommonConfigServiceInterface;
use MartenaSoft\Content\Controller\AbstractContentController;
use MartenaSoft\Content\Controller\CommonEntityInterface;

use MartenaSoft\Content\Entity\ConfigInterface;
use MartenaSoft\Content\Exception\ParseUrlErrorException;
use MartenaSoft\Content\Service\ParserUrlService;
use MartenaSoft\Menu\Entity\MenuInterface;
use MartenaSoft\Menu\Repository\MenuRepository;
use MartenaSoft\Seo\Repository\SeoRepository;
use MartenaSoft\Site\Entity\SiteConfig;
use MartenaSoft\Site\MartenaSoftSiteBundle;
use MartenaSoft\Site\Repository\ArticleRepository;
use MartenaSoft\Site\Repository\SiteConfigRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractContentController
{
    public const ROOT_NODE_NAME = 'Article';
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

    /* public function page(Request $request, string $path): Response
     {
         try {
             $response = parent::page($request, $path);
         } catch (ParseUrlErrorException $exception) {

           //  dump($exception); die;
         }
         return $response;
     }*/

    public function previewInMain(?array $items = null): Response
    {
        if ($items === null) {
            $queryBuilder = $this
                ->articleRepository
                ->getItemQueryBuilder()
                ->setFirstResult(0)
                ->setMaxResults(10);

            $queryBuilder
                ->andWhere(ArticleRepository::getAlias() . ".dateTime<=:now")
                ->setParameter("now", new \DateTime('now'));

            $items = $queryBuilder->getQuery()->getResult();
        }


        return $this->render('@MartenaSoftSite/article/preview_in_main.html.twig', [
            'items' => $items
        ]);
    }

    protected function getFindUrlQueryBuilder(): ?QueryBuilder
    {
        return $this->articleRepository->getPageQueryBuilder();
    }

    protected function getResponse(PageDataInterface $pageData): Response
    {
        $menu = $pageData->getActiveData()->getMenu();

        $subSectionsQueryBuilder = $this
            ->articleRepository
            ->getSubSectionsItemsQueryBuilder($menu);

        return $this->render('@MartenaSoftSite/site/page.html.twig', [
            'pageData' => $pageData,
            'subItems' => $subSectionsQueryBuilder->getQuery()->getResult()
        ]);
    }

    protected function getRootMenuEntity(): ?MenuInterface
    {
        $result = $this
            ->menuRepository
            ->findOneByNameQueryBuilder(self::ROOT_NODE_NAME)
            ->getQuery()
            ->getOneOrNullResult();
        return $result;
    }

    protected function getConfig(string $url): ?ConfigInterface
    {
        $configData = $this->commonConfigService->get(MartenaSoftSiteBundle::getConfigName());
        return $this->commonConfigService->array2ConfigEntity($configData, new SiteConfig());
    }
}
