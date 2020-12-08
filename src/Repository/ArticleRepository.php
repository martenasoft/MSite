<?php

namespace MartenaSoft\Site\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use MartenaSoft\Content\Repository\AbstractContentRepository;
use MartenaSoft\Menu\Entity\MenuInterface;
use MartenaSoft\Menu\Repository\MenuRepository;
use MartenaSoft\Seo\Repository\SeoRepository;
use MartenaSoft\Site\Entity\Article;

class ArticleRepository extends AbstractContentRepository
{
    private MenuRepository $menuRepository;

    public function __construct(ManagerRegistry $registry, MenuRepository $menuRepository)
    {
        parent::__construct($registry, Article::class);
        $this->menuRepository = $menuRepository;
    }

    public static function getAlias(): string
    {
        return 'a';
    }

    public function getPageQueryBuilder(): QueryBuilder
    {
        return $this
            ->getQueryBuilder()
            ->innerJoin(ArticleRepository::getAlias() . '.menu', MenuRepository::getAlias())
            ->leftJoin(ArticleRepository::getAlias() . '.seo', SeoRepository::getAlias())
            ;
    }

    public function getSubSectionsItemsQueryBuilder(MenuInterface $menu, ?QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return  $this
            ->menuRepository
            ->getAllSubItemsQueryBuilder($menu,

                $this->getQueryBuilder($queryBuilder)
                ->innerJoin(static::getAlias().'.menu', MenuRepository::getAlias())
            );
    }
}
