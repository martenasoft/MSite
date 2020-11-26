<?php

namespace MartenaSoft\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use MartenaSoft\Common\Entity\CommonEntityInterface;
use MartenaSoft\Common\Library\CommonStatusInterface;
use MartenaSoft\Menu\Entity\BaseMenuInterface;
use MartenaSoft\Menu\Entity\Menu;
use MartenaSoft\Menu\Entity\MenuInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Site\Repository\ArticleRepository;

/**
 * @ORM\Entity(repositoryClass="MartenaSoft\Site\Repository\ArticleRepository")
 * @UniqueEntity(
 *     fields={"name"}
 * )
 */

class Article implements CommonStatusInterface, BaseMenuInterface, CommonEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Assert\NotBlank()
     * @ORM\Column()
     */
    private ?string $name;

    /** @ORM\Column(type="smallint") */
    private ?int $status = CommonStatusInterface::STATUS_ACTIVE;

    /** @ORM\Column(nullable=true, type="text") */
    private ?string $preview;

    /** @ORM\Column(nullable=true, type="text") */
    private ?string $detail;

    /** @ORM\Column(type="datetime") */
    private ?\DateTime $dateTime;

    /** @ORM\ManyToOne(targetEntity="MartenaSoft\Menu\Entity\Menu") */
    private ?MenuInterface $menu;

    public function __construct()
    {
        $this->setDateTime(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }



    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(?string $preview): self
    {
        $this->preview = $preview;
        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;
        return $this;
    }

    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(?\DateTime $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;
        return $this;
    }
}