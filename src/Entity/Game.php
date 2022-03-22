<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    public function __toString()
    {
        return $this->title;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rules;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $ageMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearOut;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $editor;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $distributor;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $illustrator;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="Game", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="games")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="owns")
     */
    private $owners;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=GameContent::class, mappedBy="game", orphanRemoval=true)
     */
    private $gameContents;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->owners = new ArrayCollection();
        $this->gameContents = new ArrayCollection();
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(User $user): self
    {
        if (!$this->owners->contains($user)) {
            $this->owners[] = $user;
            $user->addOwn($this);
        }

        return $this;
    }

    public function removeOwner(User $user): self
    {
        if ($this->owners->removeElement($user)) {
            $user->removeOwn($this);
        }

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(?string $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function getPlayerMin(): ?int
    {
        return $this->playerMin;
    }

    public function setPlayerMin(int $playerMin): self
    {
        $this->playerMin = $playerMin;

        return $this;
    }

    public function getPlayerMax(): ?int
    {
        return $this->playerMax;
    }

    public function setPlayerMax(int $playerMax): self
    {
        $this->playerMax = $playerMax;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getYearOut(): ?int
    {
        return $this->yearOut;
    }

    public function setYearOut(int $yearOut): self
    {
        $this->yearOut = $yearOut;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(?string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getDistributor(): ?string
    {
        return $this->distributor;
    }

    public function setDistributor(?string $distributor): self
    {
        $this->distributor = $distributor;

        return $this;
    }

    public function getIllustrator(): ?string
    {
        return $this->illustrator;
    }

    public function setIllustrator(?string $illustrator): self
    {
        $this->illustrator = $illustrator;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setGame($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getGame() === $this) {
                $comment->setGame(null);
            }
        }

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
            $gameContent->setGame($this);
        }

        return $this;
    }

    public function removeGameContent(GameContent $gameContent): self
    {
        if ($this->gameContents->removeElement($gameContent)) {
            // set the owning side to null (unless already changed)
            if ($gameContent->getGame() === $this) {
                $gameContent->setGame(null);
            }
        }

        return $this;
    }

    /**
     * Vérifie si le jeu appartient à un utilisateur
     * @param User $user - l'utilisateur
     * @return bool true si oui false sinon
     */
    public function inCollection(User $user) : bool
    {
        if ($this->owners->contains($user)) {
            return true;
        }
        return false;
    }

}
