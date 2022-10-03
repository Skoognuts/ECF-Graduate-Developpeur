<?php

namespace App\Entity;

use App\Repository\GrantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrantRepository::class)]
#[ORM\Table(name: '`grant`')]
class Grant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'grantId', targetEntity: UserGrants::class, orphanRemoval: true)]
    private Collection $userGrants;

    public function __construct()
    {
        $this->userGrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UserGrants>
     */
    public function getUserGrants(): Collection
    {
        return $this->userGrants;
    }

    public function addUserGrant(UserGrants $userGrant): self
    {
        if (!$this->userGrants->contains($userGrant)) {
            $this->userGrants->add($userGrant);
            $userGrant->setGrantId($this);
        }

        return $this;
    }

    public function removeUserGrant(UserGrants $userGrant): self
    {
        if ($this->userGrants->removeElement($userGrant)) {
            // set the owning side to null (unless already changed)
            if ($userGrant->getGrantId() === $this) {
                $userGrant->setGrantId(null);
            }
        }

        return $this;
    }
}
