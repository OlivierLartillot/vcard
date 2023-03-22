<?php

namespace App\Entity;

use App\Repository\UserSocialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSocialRepository::class)]
class UserSocial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userSocials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'userSocials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?social $social = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(nullable: true)]
    private ?bool $published = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $appearanceOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSocial(): ?social
    {
        return $this->social;
    }

    public function setSocial(?social $social): self
    {
        $this->social = $social;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getAppearanceOrder(): ?int
    {
        return $this->appearanceOrder;
    }

    public function setAppearanceOrder(?int $appearanceOrder): self
    {
        $this->appearanceOrder = $appearanceOrder;

        return $this;
    }
}
