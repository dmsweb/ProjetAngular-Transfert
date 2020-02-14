<?php

namespace App\Security\Voter;


use App\Entity\User;
use App\Entity\Depot;
use App\Security\Voter\DepotVoter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DepotVoter extends Voter implements VoterInterface
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST', 'VIEW'])
            && $subject instanceof \App\Entity\Depot;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $userDepot = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$userDepot instanceof User) {
            return false;
        }
        if($userDepot->getRoles()[0]==="ROLE_SUPER_ADMIN" && $subject->getRoles()[0] != "ROLE_SUPER_ADMIN" ){
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'POST':

                if($userDepot->getRoles()[0]==="ROLE_ADMIN" && ($subject->getRoles()[0] === "ROLE_CAISSIER")){
                    return true;

                }else if($userDepot->getRoles()[0]==="ROLE_PARTENAIRE"){

                    return false;
                }
                      
                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
