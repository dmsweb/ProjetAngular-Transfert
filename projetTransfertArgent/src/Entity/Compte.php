<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Partenaire;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroCompte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="numeroCompte")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="compte")
     */
    private $idCompte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes")
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes1")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaireCompte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affection", mappedBy="compte")
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="depot")
     */
    private $fdepot;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="retrait")
     */
    private $fretrait;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->idCompte = new ArrayCollection();
        $this->compte = new ArrayCollection();
        $this->fdepot = new ArrayCollection();
        $this->fretrait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setNumeroCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getNumeroCompte() === $this) {
                $depot->setNumeroCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdCompte(): Collection
    {
        return $this->idCompte;
    }

    public function addIdCompte(User $idCompte): self
    {
        if (!$this->idCompte->contains($idCompte)) {
            $this->idCompte[] = $idCompte;
            $idCompte->setCompte($this);
        }

        return $this;
    }

    public function removeIdCompte(User $idCompte): self
    {
        if ($this->idCompte->contains($idCompte)) {
            $this->idCompte->removeElement($idCompte);
            // set the owning side to null (unless already changed)
            if ($idCompte->getCompte() === $this) {
                $idCompte->setCompte(null);
            }
        }

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getPartenaireCompte(): ?Partenaire
    {
        return $this->partenaireCompte;
    }

    public function setPartenaireCompte(?Partenaire $partenaireCompte): self
    {
        $this->partenaireCompte = $partenaireCompte;

        return $this;
    }

    /**
     * @return Collection|Affection[]
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Affection $compte): self
    {
        if (!$this->compte->contains($compte)) {
            $this->compte[] = $compte;
            $compte->setCompte($this);
        }

        return $this;
    }

    public function removeCompte(Affection $compte): self
    {
        if ($this->compte->contains($compte)) {
            $this->compte->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getCompte() === $this) {
                $compte->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getFdepot(): Collection
    {
        return $this->fdepot;
    }

    public function addFdepot(Transaction $fdepot): self
    {
        if (!$this->fdepot->contains($fdepot)) {
            $this->fdepot[] = $fdepot;
            $fdepot->setDepot($this);
        }

        return $this;
    }

    public function removeFdepot(Transaction $fdepot): self
    {
        if ($this->fdepot->contains($fdepot)) {
            $this->fdepot->removeElement($fdepot);
            // set the owning side to null (unless already changed)
            if ($fdepot->getDepot() === $this) {
                $fdepot->setDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getFretrait(): Collection
    {
        return $this->fretrait;
    }

    public function addFretrait(Transaction $fretrait): self
    {
        if (!$this->fretrait->contains($fretrait)) {
            $this->fretrait[] = $fretrait;
            $fretrait->setRetrait($this);
        }

        return $this;
    }

    public function removeFretrait(Transaction $fretrait): self
    {
        if ($this->fretrait->contains($fretrait)) {
            $this->fretrait->removeElement($fretrait);
            // set the owning side to null (unless already changed)
            if ($fretrait->getRetrait() === $this) {
                $fretrait->setRetrait(null);
            }
        }

        return $this;
    }

   

}
