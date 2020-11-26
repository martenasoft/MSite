<?php

namespace MartenaSoft\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use MartenaSoft\Common\Library\CommonStatusInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Site\Repository\SiteConfigRepository;

/**
 * @ORM\Entity(repositoryClass=SiteConfigRepository::class)
 * @UniqueEntity(
 *     fields={"name", "domain", "url"}
 * )
 */
class SiteConfig implements CommonStatusInterface
{
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

    /**
     * @Assert\NotBlank()
     * @@ORM\Column()
     */
    private ?string $domain;

    /**
     * @Assert\NotBlank()
     * @@ORM\Column()
     */
    private ?string $url;

    /**
     * @Assert\NotBlank()
     * @@ORM\Column(type="smallint")
     */
    private int $status = CommonStatusInterface::STATUS_ACTIVE;
    
    /** @@ORM\Column()  */
    private ?string $redirectTo;

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

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;
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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRedirectTo(): ?string
    {
        return $this->redirectTo;
    }

    public function setRedirectTo(?string $redirectTo): self
    {
        $this->redirectTo = $redirectTo;
        return $this;
    }
}
