<?php

namespace App\Entity;

use App\Repository\AssociativeExperienceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociativeExperienceRepository::class)]
class AssociativeExperience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $period = [];

    #[ORM\Column(length: 255)]
    private ?string $organization = null;

    #[ORM\ManyToOne(inversedBy: 'associativeExperiences')]
    private ?CurriculumVitae $curriculumvitae = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPeriod(): array
    {
        return $this->period;
    }

    public function setPeriod(array $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getCurriculumVitae(): ?CurriculumVitae
    {
        return $this->curriculumvitae;
    }

    public function setCurriculumVitae(?CurriculumVitae $curriculumVitae): self
    {
        $this->curriculumvitae = $curriculumVitae;

        return $this;
    }
}
