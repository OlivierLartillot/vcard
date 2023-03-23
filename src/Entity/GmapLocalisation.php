<?php

namespace App\Entity;

use App\Repository\GmapLocalisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GmapLocalisationRepository::class)]
class GmapLocalisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $longitude = null;

    #[ORM\OneToOne(mappedBy: 'gmapLocalisation', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        // unset the owning side of the relation if necessary
        if ($company === null && $this->company !== null) {
            $this->company->setGmapLocalisation(null);
        }

        // set the owning side of the relation if necessary
        if ($company !== null && $company->getGmapLocalisation() !== $this) {
            $company->setGmapLocalisation($this);
        }

        $this->company = $company;

        return $this;
    }
}
