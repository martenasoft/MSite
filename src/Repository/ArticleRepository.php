<?php

namespace MartenaSoft\Site\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use MartenaSoft\Site\Entity\Article;

class ArticleRepository extends ServiceEntityRepository
{
    private $alias = "a";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder($this->alias);
    }
}
