<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Tarif;
use App\Entity\Compte;
use App\Entity\Transaction;
use App\Controller\TransferController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * @Route("/api")
 */
class TransferController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/envoyer", name="transaction", methods={"POST"})
     */
    public function faireTransaction(Request $request, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->montant, $values->clientEmetteur, $values->frais, $values->code, $values->typePEmetteur, 
        $values->numeroPEmetteur, $values->dateEnvoi, $values->telEmetteur, $values->commissionEmetteur, $values->depot)) 
        {
          $dateDepot= new \DateTime();
          $compte=  new Compte();
          $dept=  new Depot();
          $envoit= new Transaction();    

          $repos= $this->getDoctrine()->getRepository(Tarif::class);

        }
    }
}
