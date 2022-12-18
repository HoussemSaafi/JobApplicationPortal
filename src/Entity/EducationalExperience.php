<?php

namespace App\Entity;

use App\Repository\EducationalExperienceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationalExperienceRepository::class)]
class EducationalExperience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $university = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $period = [];

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'educationalExperiences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CurriculumVitae $curriculumvitae = null;

//    #[ORM\ManyToOne(inversedBy: 'educationalExperiences')]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?CurriculumVitae $curriclumVitae = null;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function setUniversity(string $university): self
    {
        $this->university = $university;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCurriclumVitae(): ?CurriculumVitae
    {
        return $this->curriculumvitae;
    }

    public function setCurriclumVitae(?CurriculumVitae $curriclumVitae): self
    {
        $this->curriculumvitae = $curriclumVitae;

        return $this;
    }

    public function getCurriculumvitae(): ?CurriculumVitae
    {
        return $this->curriculumvitae;
    }

    public function setCurriculumvitae(?CurriculumVitae $curriculumvitae): self
    {
        $this->curriculumvitae = $curriculumvitae;

        return $this;
    }
}
