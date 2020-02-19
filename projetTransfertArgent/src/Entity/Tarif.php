<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
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
    private $inferieur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supperieur;

    /**
     * @ORM\Column(type="float", length=255)
     */
    private $frais;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInferieur(): ?string
    {
        return $this->inferieur;
    }

    public function setInferieur(string $inferieur): self
    {
        $this->inferieur = $inferieur;

        return $this;
    }

    public function getSupperieur(): ?string
    {
        return $this->supperieur;
    }

    public function setSupperieur(string $supperieur): self
    {
        $this->supperieur = $supperieur;

        return $this;
    }

    public function getFrais(): ?string
    {
        return $this->frais;
    }

    public function setFrais(string $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

}
