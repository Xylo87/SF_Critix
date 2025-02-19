<?php

namespace App\Entity;

use App\Repository\SocialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialRepository::class)]
class Social
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $subNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'socials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Influencer $influencer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSubNumber(): ?string
    {
        return $this->subNumber;
    }

    public function setSubNumber(string $subNumber): static
    {
        $this->subNumber = $subNumber;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    // TO STRING -> Social media name
    public function __toString()
    {
        return $this->name;
    }

    public function getInfluencer(): ?Influencer
    {
        return $this->influencer;
    }

    public function setInfluencer(?Influencer $influencer): static
    {
        $this->influencer = $influencer;

        return $this;
    }
}
