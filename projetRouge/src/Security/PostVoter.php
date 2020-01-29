<?php

namespace App\Security;

use Symfony\Component\Security\Core\Security;

class PostVoter extends Voter
{
    // ...

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // ...

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // ... all the normal voter logic
    }
}