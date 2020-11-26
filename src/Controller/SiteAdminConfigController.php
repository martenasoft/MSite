<?php

namespace MartenaSoft\Site\Controller;

use MartenaSoft\Common\Controller\AbstractAdminBaseController;
use Symfony\Component\HttpFoundation\Response;

class SiteAdminConfigController extends AbstractAdminBaseController
{
    public function index(): Response
    {
        return $this->render('@MartenaSoftSite/admin_config/index.html.twig');
    }
}