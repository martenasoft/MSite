<?php

namespace MartenaSoft\Site\Repository;

use Doctrine\Persistence\ManagerRegistry;
use MartenaSoft\Content\Repository\AbstractContentRepository;
use MartenaSoft\Site\Entity\Article;

class ArticleRepository extends AbstractContentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public static function getAlias(): string
    {
        return 'a';
    }
}
