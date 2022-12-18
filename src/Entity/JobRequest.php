<?php

namespace App\Entity;

use App\Repository\JobRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRequestRepository::class)]
class JobRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;


    #[ORM\ManyToOne(inversedBy: 'jobRequests')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'jobRequests')]
    private ?Entreprise $entreprise = null;

    #[ORM\Column(length: 100)]
    private ?string $refsujet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getRefsujet(): ?string
    {
        return $this->refsujet;
    }

    public function setRefsujet(string $refsujet): self
    {
        $this->refsujet = $refsujet;

        return $this;
    }
}
