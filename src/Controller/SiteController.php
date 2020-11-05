<?php

namespace MartenaSoft\Site\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('@MartenaSoftSite/site/index.html.twig');
    }
}