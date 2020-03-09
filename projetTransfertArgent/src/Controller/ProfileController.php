<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profile;
use App\Controller\ProfileController;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class ProfileController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/profiles", name="profile", methods={"GET"})
     */
    public function profileAction(ProfileRepository $ripo)
    {
        
        $user = new User();
        $profiles=$ripo->findAll();
        // dd($profiles);

       $user= $this->tokenStorage->getToken()->getUser();

       if ($user->getRoles()[0] ==='ROLE_SUPER_ADMIN') {
         
           $profiles= $this->getDoctrine()->getRepository(Profile::class);

           $profile= $profiles->findByLibelle(array('libelle' =>
           'ROLE_ADMIN', 
           'ROLE_CAISSIER'
        ));
        $datas= array();
        foreach ($profile as $key => $result) {
            $datas[$key]['id'] = $result->getId();
            $datas[$key]['libelle'] = $result->getLibelle();
            
        }
        return new JsonResponse($datas);
        
      
       
       }
     elseif($user->getRoles()[0] ==='ROLE_ADMIN')
     {
        $profiles= $this->getDoctrine()->getRepository(Profile::class);
        $profile1= $profiles->findByLibelle(array('libelle' => 
        'ROLE_CAISSIER', 
        'ROLE_PARTENAIRE', 
        'ROLE_ADMIN_PARTENAIRE'
     ));
    //  dd($profile1);
    $data= array();
    foreach ($profile1 as $key => $results) {
        $data[$key]['id'] = $results->getId();
        $data[$key]['libelle'] = $results->getLibelle();
        
    }
    return new JsonResponse($data);
          
     }else {
        
     }
        
    }
   
}
