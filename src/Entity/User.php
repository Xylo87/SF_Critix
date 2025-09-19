<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Gedmo\Mapping\Annotation\Slug;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
// use Freema\PerspectiveApiBundle\Validator\PerspectiveContent;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'An account already exists with this email')]
#[UniqueEntity(fields: ['nickName'], message: 'An account already exists with this nickname')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique:true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50, unique:true)]
    private ?string $nickName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[PerspectiveContent(
    //     thresholds: [
    //         'TOXICITY' => 0.5,
    //         'PROFANITY' => 0.3
    //     ],
    //     message: 'Your comment contains inappropriate content.'
    // )]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options:["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $accountDate = null;

    /**
     * @var Collection<int, Influencer>
     */
    #[ORM\ManyToMany(targetEntity: Influencer::class, mappedBy: 'users')]
    private Collection $influencers;

    /**
     * @var Collection<int, Critic>
     */
    #[ORM\ManyToMany(targetEntity: Critic::class, mappedBy: 'users')]
    private Collection $critics;

    /**
     * @var Collection<int, Opinion>
     */
    #[ORM\OneToMany(targetEntity: Opinion::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $opinions;

    /**
     * @var Collection<int, Agreement>
     */
    #[ORM\OneToMany(targetEntity: Agreement::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $agreements;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user', orphanRemoval: false)]
    private Collection $comments;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Piece>
     */
    #[ORM\ManyToMany(targetEntity: Piece::class, inversedBy: 'users')]
    private Collection $pieces;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['nickName'])]
    private ?string $slug = null;

    public function __construct()
    {
        $this->influencers = new ArrayCollection();
        $this->critics = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->agreements = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->accountDate = new \DateTime();
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): static
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getAccountDate(): ?\DateTimeInterface
    {
        return $this->accountDate;
    }

    public function setAccountDate(\DateTimeInterface $accountDate): static
    {
        $this->accountDate = $accountDate;

        return $this;
    }

    // > English date formatter fonction
    public function getCreationDateENG(): ?string 
    {        
        return $this->accountDate->format('M. jS, Y');
    }

    // TO STRING -> User NickName
    public function __toString()
    {
        return $this->nickName;
    }

    /**
     * @return Collection<int, Influencer>
     */
    public function getInfluencers(): Collection
    {
        return $this->influencers;
    }

    public function addInfluencer(Influencer $influencer): static
    {
        if (!$this->influencers->contains($influencer)) {
            $this->influencers->add($influencer);
            $influencer->addUser($this);
        }

        return $this;
    }

    public function removeInfluencer(Influencer $influencer): static
    {
        if ($this->influencers->removeElement($influencer)) {
            $influencer->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Critic>
     */
    public function getCritics(): Collection
    {
        return $this->critics;
    }

    public function addCritic(Critic $critic): static
    {
        if (!$this->critics->contains($critic)) {
            $this->critics->add($critic);
            $critic->addUser($this);
        }

        return $this;
    }

    public function removeCritic(Critic $critic): static
    {
        if ($this->critics->removeElement($critic)) {
            $critic->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Opinion>
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): static
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions->add($opinion);
            $opinion->setUser($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): static
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getUser() === $this) {
                $opinion->setUser(null);
            }
        }

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
            $agreement->setUser($this);
        }

        return $this;
    }

    public function removeAgreement(Agreement $agreement): static
    {
        if ($this->agreements->removeElement($agreement)) {
            // set the owning side to null (unless already changed)
            if ($agreement->getUser() === $this) {
                $agreement->setUser(null);
            }
        }

        return $this;
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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        $this->pieces->removeElement($piece);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
