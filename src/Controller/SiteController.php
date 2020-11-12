<?php

namespace MartenaSoft\Site\Controller;

use MartenaSoft\Content\Controller\AbstractContentController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractContentController
{

    public function index(Request $request, string $path): Response
    {
        $rootNode = $this->getMenuRepository()->findOneByName('test 1');

        $this->getActiveEntityByUrl($rootNode, $path);
        return $this->render('@MartenaSoftSite/site/index.html.twig');
    }
}