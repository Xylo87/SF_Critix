<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CriticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Assert\LessThanOrEqual(value: new \DateTime('today'), message: "Date cannot be set in the future")]
    private ?\DateTimeInterface $originDatePost = null;

    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Piece $piece = null;

    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Influencer $influencer = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'critics')]
    private Collection $users;

    /**
     * @var Collection<int, Agreement>
     */
    #[ORM\OneToMany(targetEntity: Agreement::class, mappedBy: 'critic', orphanRemoval: true)]
    private Collection $agreements;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'critic', orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->agreements = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->datePost = new \DateTime();
    }

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

    // > English date formatter fonction
    public function getDatePostENG(): ?string 
    {        
        return $this->datePost->format('M. jS, Y');
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

    // > English date formatter fonction
    public function getOriginDatePostENG(): ?string 
    {        
        return $this->originDatePost->format('M. jS, Y');
    }

    public function setOriginDatePost(\DateTimeInterface $originDatePost): static
    {
        $this->originDatePost = $originDatePost;

        return $this;
    }

    // TO STRING -> Critic score on 5
    public function __toString()
    {
        return $this->criticScore;
    }

    public function getPiece(): ?Piece
    {
        return $this->piece;
    }

    public function setPiece(?Piece $piece): static
    {
        $this->piece = $piece;

        return $this;
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Agreement>
     */
    public function getAgreements(): Collection
    {
        return $this->agreements;
    }

    public function addAgreement(Agreement $agreement): static
    {
        if (!$this->agreements->contains($agreement)) {
            $this->agreements->add($agreement);
            $agreement->setCritic($this);
        }

        return $this;
    }

    public function removeAgreement(Agreement $agreement): static
    {
        if ($this->agreements->removeElement($agreement)) {
            // set the owning side to null (unless already changed)
            if ($agreement->getCritic() === $this) {
                $agreement->setCritic(null);
            }
        }

        return $this;
    }

    public function getTotalAgreements(): ?float{
        
        $totalAgreements = 0;

        foreach ($this->agreements as $agreement) {
            $totalAgreements += $agreement->isOk();
        }
        return ($totalAgreements / count($this->agreements))*100;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setCritic($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCritic() === $this) {
                $comment->setCritic(null);
            }
        }

        return $this;
    }
}
