<?php

namespace MartenaSoft\Site\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Entity\NestedSetEntityInterface;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    private MenuRepository $menuRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MenuRepository $menuRepository, EntityManagerInterface $entityManager)
    {
        $this->menuRepository = $menuRepository;
        $this->entityManager = $entityManager;
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
    public function index(): Response
    {

        $this->initMenu();

        return $this->render('@MartenaSoftSite/site/index.html.twig');
    }

    private function initMenu(): void
    {
        $node1_0 = $this->getNode("Node 1.0");

        $node1_2_0 = $this->getNode("Node 1.2.0", $node1_0);
      //  $this->getEntityManager()->refresh($node1_0);
        $node1_2_1 = $this->getNode("Node 1.2.1", $node1_2_0);
        //$this->getEntityManager()->refresh($node1_2_0);
        $node1_2_2 = $this->getNode("Node 1.2.2", $node1_2_0);

   //     $this->getEntityManager()->refresh($node1_0);

        $node1_3_0 = $this->getNode("Node 1.3.0", $node1_0);
        //$this->getEntityManager()->refresh($node1_0);
        $node1_4_0 = $this->getNode("Node 1.4.0", $node1_0);

        $node1_4_1 = $this->getNode("Node 1.4.1", $node1_4_0);
        $node1_4_2 = $this->getNode("Node 1.4.1", $node1_4_0);

        $node1_5_1 = $this->getNode("Node 1.5.1", $node1_4_1);
        $node1_5_2 = $this->getNode("Node 1.5.2", $node1_4_2);
        $node1_5_3 = $this->getNode("Node 1.5.3", $node1_4_2);


      //  $this->getEntityManager()->refresh($node1_0);
    }

    private function getNode(string $name, ?NestedSetEntityInterface $parent = null): Menu
    {
        $menuNode = $this->menuRepository->get($name);

        if (!empty($parent)) {
            $this->getEntityManager()->refresh($parent);
        }

        if (empty($menuNode)) {
            $menuNode = new Menu();
            $menuNode->setName($name);
        }
        $node = $this->menuRepository->create($menuNode, $parent);;
    //    $this->entityManager->clear();
        return $node;
    }}