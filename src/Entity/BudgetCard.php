<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCardRepository")
 */
class BudgetCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-get-list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"budget-card-create", "budget-card-get-list"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-create", "budget-card-get-list"})
     */
    private $ceil;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"budget-card-create", "budget-card-get-list"})
     */
    private $limitDate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-create", "budget-card-get-list"})
     */
    private $currentMoney;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"budget-card-create"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="budgetCards", cascade={"persist"})
     * @Groups({"budget-card-create"})
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
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

    public function getCeil(): ?int
    {
        return $this->ceil;
    }

    public function setCeil(int $ceil): self
    {
        $this->ceil = $ceil;

        return $this;
    }

    public function getLimitDate(): ?\DateTimeInterface
    {
        return $this->limitDate;
    }

    public function setLimitDate(\DateTimeInterface $limitDate): self
    {
        $this->limitDate = $limitDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setBudgetCard($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getBudgetCard() === $this) {
                $user->setBudgetCard(null);
            }
        }

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCurrentMoney(): ?int
    {
        return $this->currentMoney;
    }

    public function setCurrentMoney(int $currentMoney): self
    {
        $this->currentMoney = $currentMoney;

        return $this;
    }
}