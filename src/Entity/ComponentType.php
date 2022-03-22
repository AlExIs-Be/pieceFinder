<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComponentTypeRepository;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ComponentTypeRepository::class)
 */
class ComponentType
{
    public function __toString()
    {
        return $this->type;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=GameContent::class, mappedBy="componentType", orphanRemoval=true)
     */
    private $gameContent;

    public function __construct()
    {
        $this->gameContent = new ArrayCollection();
    }

    /**
     * @return Collection<int, GameContent>
     */
    public function getGameContent(): Collection
    {
        return $this->gameContent;
    }
    public function addGameContent(GameContent $gameContent): self
    {
        if (!$this->gameContents->contains($gameContent)) {
            $this->gameContents[] = $gameContent;
            $gameContent->setType($this);
        }

        return $this;
    }

    public function removeGameContent(GameContent $gameContent): self
    {
        if ($this->gameContents->removeElement($gameContent)) {
            // set the owning side to null (unless already changed)
            if ($gameContent->getType() === $this) {
                $gameContent->setType(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

}
