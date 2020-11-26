<?php

namespace MartenaSoft\Site\Controller;

use MartenaSoft\Common\Entity\PageDataInterface;
use MartenaSoft\Common\Library\CommonValues;
use MartenaSoft\Content\Controller\AbstractContentController;
use MartenaSoft\Content\Controller\CommonEntityInterface;
use MartenaSoft\Content\Controller\ConfigInterface;
use MartenaSoft\Content\Service\ParserUrlService;
use MartenaSoft\Menu\Entity\MenuInterface;
use MartenaSoft\Menu\Repository\MenuRepository;
use MartenaSoft\Site\Entity\SiteConfig;
use MartenaSoft\Site\Repository\SiteConfigRepository;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractContentController
{
    public const ROOT_NODE_NAME = 'article';
    private ConfigInterface $defaultConfig;
    private SiteConfigRepository $configRepository;

    public function __construct(
        ParserUrlService $parserUrlService,
        MenuRepository $menuRepository,
        SiteConfigRepository $configRepository
    ) {
        parent::__construct($parserUrlService, $menuRepository);
        $this->configRepository = $configRepository;
    }

    public function index(): Response
    {
        return $this->render('@MartenaSoftSite/site/index.html.twig');
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
        $result = null;
        $result = $this->configRepository->findOneByName($url);
        if (empty($result)) {
            $result = $this->configRepository->findOneByName(CommonValues::DEFAULT_DATA_NAME);
        }

        if (empty($result)) {
            $result = new SiteConfig();
        }

        return $result;
    }
}