<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Compte;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *  @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
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
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $registreCommerce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomComplet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaireCompte")
     */
    private $comptes1;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="userParte")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="partenaire")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", mappedBy="contrat", cascade={"persist", "remove"})
     */
    private $contrat;

    public function __construct()
    {
        $this->comptes1 = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getRegistreCommerce(): ?string
    {
        return $this->registreCommerce;
    }

    public function setRegistreCommerce(string $registreCommerce): self
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes1(): Collection
    {
        return $this->comptes1;
    }

    public function addComptes1(Compte $comptes1): self
    {
        if (!$this->comptes1->contains($comptes1)) {
            $this->comptes1[] = $comptes1;
            $comptes1->setPartenaireCompte($this);
        }

        return $this;
    }

    public function removeComptes1(Compte $comptes1): self
    {
        if ($this->comptes1->contains($comptes1)) {
            $this->comptes1->removeElement($comptes1);
            // set the owning side to null (unless already changed)
            if ($comptes1->getPartenaireCompte() === $this) {
                $comptes1->setPartenaireCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUserParte($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserParte() === $this) {
                $user->setUserParte(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(Contrat $contrat): self
    {
        $this->contrat = $contrat;

        // set the owning side of the relation if necessary
        if ($contrat->getContrat() !== $this) {
            $contrat->setContrat($this);
        }

        return $this;
    }

    
}
