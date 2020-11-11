<?php

namespace MartenaSoft\Site\Entity;

use  Doctrine\ORM\Mapping as ORM;
use MartenaSoft\Common\Library\CommonValues;
use Symfony\Component\Validator\Constraint as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Site\Repository\SiteConfigRepository;

/**
 * @ORM\Entity(repositoryClass="NewsConfigRepository")
 * @UniqueEntity (
 *     fields={"name"}
 * )
 */
class NewsConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private ?int $id = null;

    private ?int $previewInMainPage = 0;

    private ?int $paginationLimit = CommonValues::SITE_PAGINATION_LIMIT;
}