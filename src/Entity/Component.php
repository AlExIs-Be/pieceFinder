<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComponentRepository::class)
 */
class Component
{
    public function __toString()
    {
        return $this->name;
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=GameContent::class, mappedBy="component")
     */
    private $gameContents;

    public function __construct()
    {
        $this->gameContents = new ArrayCollection();
    }

    public function getType(): ?ComponentType
    {
        return $this->type;
    }

    public function setType(?ComponentType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, GameContent>
     */
    public function getGameContents(): Collection
    {
        return $this->gameContents;
    }

    public function addGameContent(GameContent $gameContent): self
    {
        if (!$this->gameContents->contains($gameContent)) {
            $this->gameContents[] = $gameContent;
            $gameContent->setComponent($this);
        }

        return $this;
    }

    public function removeGameContent(GameContent $gameContent): self
    {
        if ($this->gameContents->removeElement($gameContent)) {
            // set the owning side to null (unless already changed)
            if ($gameContent->getComponent() === $this) {
                $gameContent->setComponent(null);
            }
        }

        return $this;
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

}

