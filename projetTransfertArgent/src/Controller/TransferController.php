<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Tarif;
use App\Entity\Compte;
use App\Entity\Affection;
use App\Entity\Partenaire;
use App\Entity\Transaction;
use App\Controller\TransferController;
use App\Repository\AffectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function faireTransaction(Request $request, EntityManagerInterface $entityManager, AffectionRepository $repo)
    {
        $values = json_decode($request->getContent());
        if (isset($values->montant,$values->typePEmetteur,$values->numeroPEmetteur,$values->telephoneE,$values->prenomE,$values->nomE,$values->nomsRecepteur)) 
        {
            $dateEnvoi = new \DateTime();
            $transaction = new Transaction();
            $affection= new Affection();

            //recuperation du caissier qui envoie
            $compteId = $this->tokenStorage->getToken()->getUser();
            $transaction->setTransact1($compteId);
            $compteId= $this->getDoctrine()->getRepository(Affection::class);
            $affection=$compteId->findOneById($values->id)->getCompteId();
            // dd($affection);
            
            $transaction->setDepot($affection);
            $transaction->setMontant($values->montant);
          
        //  //recuperation du caissier qui envoie
        //   $transact1 = $this->tokenStorage->getToken()->getUser();
        //   $envoit->setTransact1($transact1);   
           
          $repository = $this->getDoctrine()->getRepository(Tarif::class);
          $repos= $repository->findAll();
          foreach($repos as $key)
          {
              $key->getInferieur();
              $key->getSupperieur();
              $key->getFrais();

            if ($values->montant >= $key->getInferieur() && $values->montant <= $key->getSupperieur()) 
            {
                $frais= $key->getFrais();             
            }  
          }
          // partage des commissions

            $taxeEtats = $frais * 0.4;
            $commissionSysteme = $frais * 0.3;
            $commissionenvoie = $frais * 0.1;
            $commissionretrait = $frais * 0.2;

            $montantEnvoye = $values->montant +$frais - $commissionenvoie ;
            // //Verifier le montant dispo
            // $comptes = $affection->getCompte();

            if ($montantEnvoye >= $affection->getSolde()) {
                return $this->json([
                    'message1' => 'votre solde( ' . $affection->getSolde() . ' ) ne vous permez pas d\'effectuer cette transaction'
                ]);
            }

            $restantSolde = ($affection->getSolde()-$montantEnvoye);
            $affection->setSolde($restantSolde);

            //creation du code de transaction pour l'envoi
            $kod = 8;
            $kods = rand(1000, 9999);
            $codes = $kod . $kods;
            $transaction->setFrais($frais);
            $transaction->setCode($codes);
            $transaction->setTypePEmetteur($values->typePEmetteur);
            $transaction->setNumeroPEmetteur($values->numeroPEmetteur);
            $transaction->setNomE($values->nomE); 
            $transaction->setPrenomE($values->prenomE);
            $transaction->setTelephoneE($values->telephoneE);
            $transaction->setTelephoneR($values->telephoneR);
            $transaction->setNomsRecepteur($values->nomsRecepteur); 
            $transaction->setDateEnvoi($dateEnvoi);
            $transaction->setTaxeEtats($taxeEtats);
            // $transaction->setDepot($Compte);
            $transaction->setCommissionSysteme($commissionSysteme);
            $transaction->setCommissionenvoie($commissionenvoie);
            $transaction->setCommissionretrait($commissionretrait);
            $transaction->setStatus('envoye');
            $entityManager->persist($transaction);
           $entityManager->flush();


        $data = [
            'status' => 201,
            'message' => 'Le transfert a ete envoye avec succes: '.$values->montant
        ];
        return new JsonResponse($data, 201);
    }
    $data = [
        'status' => 500,
        'message' => 'Vous devez  remplir tous les champs correctement !'
    ];
    return new JsonResponse($data, 500);
}

 /**
 * @Route("/retrait", name="retrait", methods={"POST"})
*/
public function retrait(Request $request, EntityManagerInterface $entityManager, AffectionRepository $repo)
{
    $values = json_decode($request->getContent());
    if(isset($values->numeroPRecepteur))
    {
        $dateRetrait = new \DateTime();
        $code = new Transaction(); 
               
         $code->setCode($values->code);
        // dd($values);
         $repositori = $this->entityManager->getRepository(Transaction::class);
         $code = $repositori->findOneByCode($values->code);
         if(!$code){
            return new Response('Ce code est invalide ',Response::HTTP_CREATED);
        }

            if($code->getStatus()=="retire" ){
                return new Response('Le code est déja retiré',Response::HTTP_CREATED);
            }
        // dd($code);
        //recuperation du caissier qui envoie
        $userRetrait = $this->tokenStorage->getToken()->getUser();

        if($userRetrait->getRoles()[0] === "ROLE_CAISSIER_PARTENAIRE"){
            $compteRecepteur=$repo->findComptAffecter($userRetrait)[0]->getCompte();
            $code->setCompteRecepteur($compteRecepteur);
        }
        $code->setUserRetrait($userRetrait);
        $code->setDateRetrait($dateRetrait);
        $code->setTypePRecepteur($values->typePRecepteur);
        $code->setNumeroPRecepteur($values->numeroPRecepteur);
        // $comptes = $userCompteR->getCompte();
        // $code->setCompteRecepteur($comptes);
        $restantSolde = ($compteRecepteur->getSolde()+$code->getMontant()+$code->getCommisionretrait());
        $compteRecepteur->setSolde($restantSolde);
         $code->setStatus('retire');
        $entityManager->persist($code);
        $entityManager->flush();


    $data = [
            'status' => 201,
            'message' => 'Le retrait est fait'
        ];
        return new JsonResponse($data, 201);
    }
    $data = [
        'status' => 500,
        'message' => 'Vous devez renseigner un login et un passwordet un ninea pour le partenaire, le numero de compte ainsi que le montant a deposer'
    ];
    return new JsonResponse($data, 500);
}

        }
    

