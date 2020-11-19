<?php

namespace MartenaSoft\Site\Controller;

use MartenaSoft\Content\Service\ParserUrlService;
use MartenaSoft\Menu\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    private ParserUrlService $parserUrlService;
    private MenuRepository $menuRepository;

    public function __construct(ParserUrlService $parserUrlService, MenuRepository $menuRepository)
    {
        $this->parserUrlService = $parserUrlService;
        $this->menuRepository = $menuRepository;
    }

    public function index(Request $request, string $path): Response
    {
        $rootNode = $this
            ->menuRepository
            ->findOneByNameQueryBuilder('test 1')
            ->getQuery()
            ->getOneOrNullResult();

        $this->parserUrlService->getActiveEntityByUrl($rootNode, $path);
        return $this->render('@MartenaSoftSite/site/index.html.twig');
    }
}