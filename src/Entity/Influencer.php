<?php

namespace App\Entity;

use App\Repository\InfluencerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfluencerRepository::class)]
class Influencer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nickName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $realName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bio = null;

    /**
     * @var Collection<int, Critic>
     */
    #[ORM\OneToMany(targetEntity: Critic::class, mappedBy: 'influencer')]
    private Collection $critics;

    /**
     * @var Collection<int, Social>
     */
    #[ORM\OneToMany(targetEntity: Social::class, mappedBy: 'influencer', orphanRemoval: true, cascade: ['persist'])]
    private Collection $socials;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'influencers')]
    private Collection $users;

    public function __construct()
    {
        $this->critics = new ArrayCollection();
        $this->socials = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(?string $realName): static
    {
        $this->realName = $realName;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    // TO STRING -> Influencer NickName
    public function __toString()
    {
        return $this->nickName;
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
            $critic->setInfluencer($this);
        }

        return $this;
    }

    public function removeCritic(Critic $critic): static
    {
        if ($this->critics->removeElement($critic)) {
            // set the owning side to null (unless already changed)
            if ($critic->getInfluencer() === $this) {
                $critic->setInfluencer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Social>
     */
    public function getSocials(): Collection
    {
        return $this->socials;
    }

    public function addSocial(Social $social): static
    {
        if (!$this->socials->contains($social)) {
            $this->socials->add($social);
            $social->setInfluencer($this);
        }

        return $this;
    }

    public function removeSocial(Social $social): static
    {
        if ($this->socials->removeElement($social)) {
            // set the owning side to null (unless already changed)
            if ($social->getInfluencer() === $this) {
                $social->setInfluencer(null);
            }
        }

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
}
