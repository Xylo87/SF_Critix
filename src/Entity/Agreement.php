<?php

namespace App\Entity;

use App\Repository\AgreementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgreementRepository::class)]
class Agreement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isOk = null;

    #[ORM\ManyToOne(inversedBy: 'agreements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Critic $critic = null;

    #[ORM\ManyToOne(inversedBy: 'agreements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isOk(): ?bool
    {
        return $this->isOk;
    }

    public function setIsOk(?bool $isOk): static
    {
        $this->isOk = $isOk;

        return $this;
    }


    public function __toString()
    {
        return $this->isOk;
    }

    public function getCritic(): ?Critic
    {
        return $this->critic;
    }

    public function setCritic(?Critic $critic): static
    {
        $this->critic = $critic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
