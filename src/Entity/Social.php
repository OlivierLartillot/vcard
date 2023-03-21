<?php

namespace App\Entity;

use App\Repository\SocialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialRepository::class)]
class Social
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(nullable: true)]
    private ?bool $published = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $orderAppearance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getOrderAppearance(): ?int
    {
        return $this->orderAppearance;
    }

    public function setOrderAppearance(?int $orderAppearance): self
    {
        $this->orderAppearance = $orderAppearance;

        return $this;
    }
}
