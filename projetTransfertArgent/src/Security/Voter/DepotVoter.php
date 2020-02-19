<?php

namespace App\Security\Voter;


use App\Entity\User;
use App\Entity\Depot;
use App\Security\Voter\DepotVoter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DepotVoter extends Voter 
{
    protected function supports($attribute, $subject)
    {
        
        return  $subject instanceof \App\Entity\Depot && in_array($attribute, array(
            'ROLE_SUPER_ADMIN', 
            'ROLE_ADMIN',
            'ROLE_CAISSIER',
            'ROLE_PARTENAIRE'
            
        ));
        
    }

    protected function voteOnAttribute($attribute, $object, TokenInterface $token)
    {
        $userDepot = $token->getUser();

        if(in_array('ROLE_SUPER_ADMIN', $userDepot->getRoles()) or in_array('ROLE_ADMIN', $userDepot->getRoles()))
        {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
     

       if(in_array('ROLE_CAISSIER', $userDepot->getRoles()))
       {
         foreach($userDepot->getCaissier() as $caissier)
           if ($caissier->getDepot()->contains($object)) 
           {
                return true;
            }
        }
          if(in_array('ROLE_PARTENAIRE', $userDepot->getRoles()))
          {
           if ($userDepot->getDepot()->contains($object))
            {
            return false;
           }
                  
         }
                      
            //     break;
            // case 'VIEW':
            //     // logic to determine if the user can VIEW
            //     // return true or false
            //     break;
        

        return false;
    }
}
