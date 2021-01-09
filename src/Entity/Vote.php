<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 */
class Vote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="vote")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="votes", )
     */
    private $Candidat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->Candidat;
    }

    public function setCandidat(?Candidat $Candidat): self
    {
        $this->Candidat = $Candidat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeInterface $Created_at): self
    {
        $this->Created_at = $Created_at;

        return $this;
    }
}
