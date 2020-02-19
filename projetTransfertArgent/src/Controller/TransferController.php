<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Tarif;
use App\Entity\Compte;
use App\Entity\Transaction;
use App\Controller\TransferController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function faireTransaction(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $values = json_decode($request->getContent());
        if (isset($values->montant,$values->clientEmetteur,$values->frais,$values->code,$values->typePEmetteur, 
        $values->numeroPEmetteur,$values->dateEnvoi,$values->telEmetteur,$values->commissionEmetteur,$values->prenom,$values->nom)) 
        {
          $dateDepot= new \DateTime();
          $compte=  new Compte();
          $user= new user();
          $envoit= new Transaction();
          $envoit->setMontant($values->montant);

          $transact1 = $this->tokenStorage->getToken()->getUser();
          $envoit->setTransact1($transact1);    

          $repository= $this->getDoctrine()->getRepository(Tarif::class);
          $repos= $repository->getfindAll();
          foreach($repos as $key)
          {
              $key->getInferieur();
              $key->getSupperieur();
              $key->getFais();

            if ($values->montant >= $key->getInferieur() && $values->montant <= $key->getSupperieur()) 
            {
                $frais= $key->getFrais();             
            }  
          }
          // partage des commissions

            $taxeEtats = $frais * 0.4;
            $commissionSysteme = $frais * 0.3;
            $commissionEmetteur = $frais * 0.1;
            $commissionRecepteur = $frais * 0.2;

            $montantEnvoye = $commissionEmetteur + $values->montant;
            //Verifier le montant dispo
            $revfcompte = $transact1->getCompte();
            // var_dump($comptes); die();
            if ($montantEnvoye >= $revfcompte->getSolde()) {
                return $this->json([
                    'message1' => 'votre solde( ' . $revfcompte->getSolde() . ' ) ne vous permez pas d\'effectuer cette transaction'
                ]);
            }

            $restantSolde = ($revfcompte->getSolde()-$commissionEmetteur + $values->montant);
            $revfcompte->setSolde($restantSolde);

            //creation du code de transaction pour l'envoi
            $kod = "DMS";
            $kods = rand(1000, 9999);
            $codes = $kod . $kods;
            $envoit->setFrais($frais);
            $envoit->setCode($codes);
            $envoit->setTypeEmetteur($values->typePEmetteur);
            $envoit->setNumeroPEmetteur($values->numeroPieceE);
            $envoit->setNomCompletE($values->nomCompletE); 
            $envoit->setTelephoneE($values->telephoneE);
            $envoit->setTelephoneR($values->telephoneR);
            $envoit->setNomsRecepteur($values->nomsRecepteur); 
            $envoit->setDateEnvoi($dateEnvoi);
            $envoit->setTaxeEtat($taxeEtat);
            $envoit->setCompteEmetteur($comptes);
            $envoit->setCommissionSysteme($commissionSysteme);
            $envoit->setCommissionE($commissionE);
            $envoit->setCommisionR($commissionR);
            $envoit->setStatus('envoye');
            $entityManager->persist($envoit);
           $entityManager->flush();

        }
    }
}
