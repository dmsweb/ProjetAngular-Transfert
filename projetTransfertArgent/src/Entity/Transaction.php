<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typePEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPEmetteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telEmetteur;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionEmetteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typePRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPRecepteur;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionRecepteur;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="float")
     */
    private $taxeEtats;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transaction1")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transact1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transaction2")
     * @ORM\JoinColumn(nullable=true)
     */
    private $transact2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="fdepot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="fretrait")
     */
    private $retrait;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getClientEmetteur(): ?string
    {
        return $this->clientEmetteur;
    }

    public function setClientEmetteur(string $clientEmetteur): self
    {
        $this->clientEmetteur = $clientEmetteur;

        return $this;
    }

    public function getTypePEmetteur(): ?string
    {
        return $this->typePEmetteur;
    }

    public function setTypePEmetteur(string $typePEmetteur): self
    {
        $this->typePEmetteur = $typePEmetteur;

        return $this;
    }

    public function getNumeroPEmetteur(): ?string
    {
        return $this->numeroPEmetteur;
    }

    public function setNumeroPEmetteur(string $numeroPEmetteur): self
    {
        $this->numeroPEmetteur = $numeroPEmetteur;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getTelEmetteur(): ?string
    {
        return $this->telEmetteur;
    }

    public function setTelEmetteur(string $telEmetteur): self
    {
        $this->telEmetteur = $telEmetteur;

        return $this;
    }

    public function getCommissionEmetteur(): ?float
    {
        return $this->commissionEmetteur;
    }

    public function setCommissionEmetteur(float $commissionEmetteur): self
    {
        $this->commissionEmetteur = $commissionEmetteur;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getClientRecepteur(): ?string
    {
        return $this->clientRecepteur;
    }

    public function setClientRecepteur(string $clientRecepteur): self
    {
        $this->clientRecepteur = $clientRecepteur;

        return $this;
    }

    public function getTypePRecepteur(): ?string
    {
        return $this->typePRecepteur;
    }

    public function setTypePRecepteur(string $typePRecepteur): self
    {
        $this->typePRecepteur = $typePRecepteur;

        return $this;
    }

    public function getTelRecepteur(): ?string
    {
        return $this->telRecepteur;
    }

    public function setTelRecepteur(string $telRecepteur): self
    {
        $this->telRecepteur = $telRecepteur;

        return $this;
    }

    public function getNumeroPRecepteur(): ?string
    {
        return $this->numeroPRecepteur;
    }

    public function setNumeroPRecepteur(string $numeroPRecepteur): self
    {
        $this->numeroPRecepteur = $numeroPRecepteur;

        return $this;
    }

    public function getCommissionRecepteur(): ?float
    {
        return $this->commissionRecepteur;
    }

    public function setCommissionRecepteur(float $commissionRecepteur): self
    {
        $this->commissionRecepteur = $commissionRecepteur;

        return $this;
    }

    public function getCommissionSysteme(): ?float
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(float $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getTaxeEtats(): ?float
    {
        return $this->taxeEtats;
    }

    public function setTaxeEtats(float $taxeEtats): self
    {
        $this->taxeEtats = $taxeEtats;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTransact1(): ?User
    {
        return $this->transact1;
    }

    public function setTransact1(?User $transact1): self
    {
        $this->transact1 = $transact1;

        return $this;
    }

    public function getTransact2(): ?User
    {
        return $this->transact2;
    }

    public function setTransact2(?User $transact2): self
    {
        $this->transact2 = $transact2;

        return $this;
    }

    public function getDepot(): ?Compte
    {
        return $this->depot;
    }

    public function setDepot(?Compte $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getRetrait(): ?Compte
    {
        return $this->retrait;
    }

    public function setRetrait(?Compte $retrait): self
    {
        $this->retrait = $retrait;

        return $this;
    }
}
