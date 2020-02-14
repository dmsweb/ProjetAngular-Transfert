<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Entity\Transaction;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource( 
 *   collectionOperations={
 *          "get",
 *          "post"={  
 *  "access_control"="is_granted('POST', object)",
*}
 *     }
 * )
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields= {"login"}, message= "L'email est déjà utilisé")
 * @UniqueEntity(fields= {"username"}, message= "Le nom d'utilisateur est déjà utilisé")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir minimum 8 caractères")
     */ 
     
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="L'email n'est pas valide")
     */
    private $login;

    /**
     * @ORM\Column(type="json")
     */
    private $roles=[];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="transact1")
     */
    private $transaction1;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="transact2")
     */
    private $transaction2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="depotuser")
     */
    private $iduserDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="idCompte")
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="iduser")
     */
    private $comptes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     */
    private $userParte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="user")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affection", mappedBy="user")
     */
    private $user;

    public function __construct()
    {
        $this->transaction1 = new ArrayCollection();
        $this->transaction2 = new ArrayCollection();
        $this->iduserDepot = new ArrayCollection();
        $this->comptes = new ArrayCollection();
        $this->partenaire = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
       return null;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        return null;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [strtoupper($this->profile->getLibelle())];
    }


    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction1(): Collection
    {
        return $this->transaction1;
    }

    public function addTransaction1(Transaction $transaction1): self
    {
        if (!$this->transaction1->contains($transaction1)) {
            $this->transaction1[] = $transaction1;
            $transaction1->setTransact1($this);
        }

        return $this;
    }

    public function removeTransaction1(Transaction $transaction1): self
    {
        if ($this->transaction1->contains($transaction1)) {
            $this->transaction1->removeElement($transaction1);
            // set the owning side to null (unless already changed)
            if ($transaction1->getTransact1() === $this) {
                $transaction1->setTransact1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction2(): Collection
    {
        return $this->transaction2;
    }

    public function addTransaction2(Transaction $transaction2): self
    {
        if (!$this->transaction2->contains($transaction2)) {
            $this->transaction2[] = $transaction2;
            $transaction2->setTransact2($this);
        }

        return $this;
    }

    public function removeTransaction2(Transaction $transaction2): self
    {
        if ($this->transaction2->contains($transaction2)) {
            $this->transaction2->removeElement($transaction2);
            // set the owning side to null (unless already changed)
            if ($transaction2->getTransact2() === $this) {
                $transaction2->setTransact2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getIduserDepot(): Collection
    {
        return $this->iduserDepot;
    }

    public function addIduserDepot(Depot $iduserDepot): self
    {
        if (!$this->iduserDepot->contains($iduserDepot)) {
            $this->iduserDepot[] = $iduserDepot;
            $iduserDepot->setDepotuser($this);
        }

        return $this;
    }

    public function removeIduserDepot(Depot $iduserDepot): self
    {
        if ($this->iduserDepot->contains($iduserDepot)) {
            $this->iduserDepot->removeElement($iduserDepot);
            // set the owning side to null (unless already changed)
            if ($iduserDepot->getDepotuser() === $this) {
                $iduserDepot->setDepotuser(null);
            }
        }

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setIduser($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getIduser() === $this) {
                $compte->setIduser(null);
            }
        }

        return $this;
    }

    public function getUserParte(): ?Partenaire
    {
        return $this->userParte;
    }

    public function setUserParte(?Partenaire $userParte): self
    {
        $this->userParte = $userParte;

        return $this;
    }

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaire(): Collection
    {
        return $this->partenaire;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaire->contains($partenaire)) {
            $this->partenaire[] = $partenaire;
            $partenaire->setUser($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaire->contains($partenaire)) {
            $this->partenaire->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getUser() === $this) {
                $partenaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Affection[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Affection $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(Affection $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }

}

   