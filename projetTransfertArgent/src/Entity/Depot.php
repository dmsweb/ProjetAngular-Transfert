<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Compte;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
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
    private $montantDepot;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="iduserDepot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depotuser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numeroCompte;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDepot(): ?string
    {
        return $this->montantDepot;
    }

    public function setMontantDepot(string $montantDepot): self
    {
        $this->montantDepot = $montantDepot;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDepotuser(): ?User
    {
        return $this->depotuser;
    }

    public function setDepotuser(?User $depotuser): self
    {
        $this->depotuser = $depotuser;

        return $this;
    }

    public function getNumeroCompte(): ?Compte
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(?Compte $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

}
