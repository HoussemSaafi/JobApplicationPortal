<?php

namespace App\Entity;

use App\Repository\CurriculumVitaeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurriculumVitaeRepository::class)]
class CurriculumVitae
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedinAccount = null;

    #[ORM\Column(nullable: true)]
    private array $certificates = [];

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

//    #[ORM\OneToMany(mappedBy: 'curriculum_vitae', targetEntity: EducationalExperience::class)]
//    private Collection $educationalExperiences;

    #[ORM\OneToMany(mappedBy: 'curriculumvitae', targetEntity: ProfessionalExperience::class)]
    private Collection $professionalExperiences;

    #[ORM\OneToMany(mappedBy: 'curriculumvitae', targetEntity: AssociativeExperience::class)]
    private Collection $associativeExperiences;

    #[ORM\OneToMany(mappedBy: 'curriculumvitae', targetEntity: EducationalExperience::class)]
    private Collection $educationalExperiences;

    public function __construct()
    {
        $this->educationalExperiences = new ArrayCollection();
        $this->professionalExperiences = new ArrayCollection();
        $this->associativeExperiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLinkedinAccount(): ?string
    {
        return $this->linkedinAccount;
    }

    public function setLinkedinAccount(?string $linkedinAccount): self
    {
        $this->linkedinAccount = $linkedinAccount;

        return $this;
    }

    public function getCertificates(): array
    {
        return $this->certificates;
    }

    public function setCertificates(?array $certificates): self
    {
        $this->certificates = $certificates;

        return $this;
    }

    public function updateCertificates(?array $certificat):self
    {
        //add item to array not join two arrays
        $this -> certificates [count($this->certificates)] = $certificat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, EducationalExperience>
     */
    public function getEducationalExperiences(): Collection
    {
        return $this->educationalExperiences;
    }

    public function addEducationalExperience(EducationalExperience $educationalExperience): self
    {
        if (!$this->educationalExperiences->contains($educationalExperience)) {
            $this->educationalExperiences->add($educationalExperience);
            $educationalExperience->setCurriclumVitae($this);
        }

        return $this;
    }

    public function removeEducationalExperience(EducationalExperience $educationalExperience): self
    {
        if ($this->educationalExperiences->removeElement($educationalExperience)) {
            // set the owning side to null (unless already changed)
            if ($educationalExperience->getCurriclumVitae() === $this) {
                $educationalExperience->setCurriclumVitae(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfessionalExperience>
     */
    public function getProfessionalExperiences(): Collection
    {
        return $this->professionalExperiences;
    }

    public function addProfessionalExperience(ProfessionalExperience $professionalExperience): self
    {
        if (!$this->professionalExperiences->contains($professionalExperience)) {
            $this->professionalExperiences->add($professionalExperience);
            $professionalExperience->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeProfessionalExperience(ProfessionalExperience $professionalExperience): self
    {
        if ($this->professionalExperiences->removeElement($professionalExperience)) {
            // set the owning side to null (unless already changed)
            if ($professionalExperience->getCurriculumVitae() === $this) {
                $professionalExperience->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AssociativeExperience>
     */
    public function getAssociativeExperiences(): Collection
    {
        return $this->associativeExperiences;
    }

    public function addAssociativeExperience(AssociativeExperience $associativeExperience): self
    {
        if (!$this->associativeExperiences->contains($associativeExperience)) {
            $this->associativeExperiences->add($associativeExperience);
            $associativeExperience->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeAssociativeExperience(AssociativeExperience $associativeExperience): self
    {
        if ($this->associativeExperiences->removeElement($associativeExperience)) {
            // set the owning side to null (unless already changed)
            if ($associativeExperience->getCurriculumVitae() === $this) {
                $associativeExperience->setCurriculumVitae(null);
            }
        }

        return $this;
    }

}
