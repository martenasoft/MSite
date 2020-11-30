<?php

namespace MartenaSoft\Site\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MartenaSoft\Common\Repository\CommonRepositoryInterface;
use MartenaSoft\Site\Entity\SiteConfig;

class SiteConfigRepository extends ServiceEntityRepository implements CommonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteConfig::class);
    }

    public function getRepositoryAlias(): string
    {
        return 'sc';
    }


    public function getConfigQueryBuilder1(string $name)
    {
        return $this
            ->createQueryBuilder($this->getRepositoryAlias())
            ->andWhere($this->getRepositoryAlias().'name=:name')
            ->setParameter('name', $name)
            ;
    }
}
