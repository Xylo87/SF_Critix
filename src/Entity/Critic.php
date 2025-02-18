<?php

namespace App\Entity;

use App\Repository\CriticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriticRepository::class)]
class Critic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $media = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    #[ORM\Column(options:["default" => 0])]
    private ?float $criticScore = null;

    #[ORM\Column(options:["default" => 0])]
    private ?int $lengthMin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options:["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $datePost = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $originDatePost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getCriticScore(): ?float
    {
        return $this->criticScore;
    }

    public function setCriticScore(float $criticScore): static
    {
        $this->criticScore = $criticScore;

        return $this;
    }

    public function getLengthMin(): ?int
    {
        return $this->lengthMin;
    }

    public function setLengthMin(int $lengthMin): static
    {
        $this->lengthMin = $lengthMin;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->datePost;
    }

    public function setDatePost(\DateTimeInterface $datePost): static
    {
        $this->datePost = $datePost;

        return $this;
    }

    public function getOriginDatePost(): ?\DateTimeInterface
    {
        return $this->originDatePost;
    }

    public function setOriginDatePost(\DateTimeInterface $originDatePost): static
    {
        $this->originDatePost = $originDatePost;

        return $this;
    }


    public function __toString()
    {
        return $this->criticScore;
    }
}
