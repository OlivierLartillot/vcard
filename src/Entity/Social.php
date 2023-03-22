<?php

namespace App\Entity;

use App\Repository\SocialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $defaultImage = null;

    #[ORM\OneToMany(mappedBy: 'social', targetEntity: UserSocial::class)]
    private Collection $userSocials;

    public function __construct()
    {
        $this->userSocials = new ArrayCollection();
    }

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

    public function getDefaultImage(): ?string
    {
        return $this->defaultImage;
    }

    public function setDefaultImage(?string $defaultImage): self
    {
        $this->defaultImage = $defaultImage;

        return $this;
    }

    /**
     * @return Collection<int, UserSocial>
     */
    public function getUserSocials(): Collection
    {
        return $this->userSocials;
    }

    public function addUserSocial(UserSocial $userSocial): self
    {
        if (!$this->userSocials->contains($userSocial)) {
            $this->userSocials->add($userSocial);
            $userSocial->setSocial($this);
        }

        return $this;
    }

    public function removeUserSocial(UserSocial $userSocial): self
    {
        if ($this->userSocials->removeElement($userSocial)) {
            // set the owning side to null (unless already changed)
            if ($userSocial->getSocial() === $this) {
                $userSocial->setSocial(null);
            }
        }

        return $this;
    }
}
