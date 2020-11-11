<?php

namespace MartenaSoft\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Site\Repository\SiteRepository;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 * @UniqueEntity(
 *     fields={"name"}
 * )
 */
class News
{
    public const STATUS_NEW = 1;
    public const STATUS_PUBLIC = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /** 
     * @Assert\NotBlank()
     * @@ORM\Column() 
     */
    private ?string $name;

    /** @@ORM\Column() */
    private ?string $url;

    /** @@ORM\Column(type="smallint") */
    private ?int $status = self::STATUS_NEW;

    /** @@ORM\Column(nullable=ture) */
    private ?string $preview;

    /** @@ORM\Column(nullable=ture) */
    private ?string $detail;

    /** @@ORM\Column(type="datetime") */
    private ?\DateTime $dateTime;

    /**
     * @return int|null
     */
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
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
}

