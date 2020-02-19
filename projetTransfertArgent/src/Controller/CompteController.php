<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Profile;
use App\Entity\Partenaire;
use App\Controller\CompteController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



/**
 * @Route("/api")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
  
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }
     /** 
     * @Route("/nouveauPartenaire", name="nouveauPartenaire", methods={"POST"})
     */
    public function nouveaucomptePartenaire(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
    
        $values = json_decode($request->getContent());
        
        if(isset($values->login,$values->password,$values->ninea,$values->montantDepot,$values->nomComplet,$values->adresse,$values->telephone,$values->registreCommerce))
        {
            $dateCreation = new \DateTime();
            $depot = new Depot();
            $compte = new Compte();                     
            $user = new User();
            $partenaire = new Partenaire();
            // $contrat =new Contrat();  
            
            $userCreateur = $this->tokenStorage->getToken()->getUser();
            
                    #####   USER   
            $roleRepo = $this->getDoctrine()->getRepository(Profile::class);
            $roles = $roleRepo->find($values->profile);
            $user->setLogin($values->login);
            $user->setIsActive($values->isActive);
            $user->setUsername($values->username);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $values->password));
            $user->setProfile($roles);
            $user->setUserParte($partenaire);
            
            $entityManager->persist($user);
         
                     ##### Partenaire

            $partenaire->setNinea($values->ninea);
            $partenaire->setRegistreCommerce($values->registreCommerce);
            $partenaire->setNomComplet($values->nomComplet);
            $partenaire->setAdresse($values->adresse);
            $partenaire->setTelephone($values->telephone);
           // dd($partenaire);
    
            $entityManager->persist($partenaire);
          
            ####    GENERATION DU NUMERO DE COMPTE  ####
            $annees = Date('y');
            $num = rand(100000000, 999999999);
            $sn = "SN";
            $numeroCompte = $sn . $num ;

                    #####   COMPTE    ######
            
            $compte->setNumeroCompte($numeroCompte);
            $compte->setSolde(0);
            $compte->setDateCreation($dateCreation);
            $compte->setIduser($user); 
            $compte->setPartenaireCompte($partenaire); 

            $entityManager->persist($compte);
            //$entityManager->flush();

            // $info = 
            // $contrat->setInformation($info);
            // $contrat->setDateCreation($dateCreation);

                    #####   DEPOT 
            $depot->setDateDepot($dateCreation);
            $depot->setMontantDepot($values->montantDepot);
            $depot->setNumeroCompte($compte);
            $depot->setDepotuser($user);

            $entityManager->persist($depot);
            //$entityManager->flush();

            ####    MIS A JOUR DU SOLDE DE COMPTE   ####
            $NouveauSolde = ($values->montantDepot+$compte->getSolde());
            $compte->setSolde($NouveauSolde);
            $entityManager->persist($compte);
            $entityManager->flush();

        $data = [
                'status' => 201,
                'message' => 'Le compte du partenaire est bien cree avec un depot initia de: '.$values->montantDepot
            ];
            return new JsonResponse($data, 201);
        }else
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner un login et un password et un ninea pour le partenaire, le numero de compte ainsi que le montant a deposer'
        ];
        return new JsonResponse($data, 500);
        }
    public function getLastCompte(){
        $ripo = $this->getDoctrine()->getRepository(Compte::class);
        $compte = $ripo->findBy([], ['id'=>'DESC']);
        if(!$compte){
            $cpt = 1;
        }else{
            $cpt = ($compte[0]->getId()+1);
        }
        return $cpt;
      }
    
}
