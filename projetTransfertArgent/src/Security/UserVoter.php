<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter implements VoterInterface
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html

        return in_array($attribute, ['POST_EDIT', 'POST_VIEW']) // les actions a faire
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {   
        $userConnect = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$userConnect instanceof UserInterface) {
            return false;
        }
        if($userConnect->getRoles()[0]==="ROLE_SUPER_ADMIN")
        {
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        
        switch ($attribute) {
            case 'POST_EDIT':   
                if($userConnect->getRoles()[0]==="ROLE_ADMIN" &&

                ($subject->getProfile()->getLibelle() === "ROLE_CAISSIER" || 
                
                $subject->getProfile()->getLibele() === "ROLE_PARTENAIRE")){
                    return true;
                }else if($userConnect->getProfile()->getLibelle()==="ROLE_CAISSIER"){
                    return false;
                }
                          
                // return true or false
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                if($userConnect->getProfile()->getLibelle() ==="ROLE_CAISSIER"){
                    return false;
                }   
                break;   
            default:
                break;
        }
        return false;
    }
}