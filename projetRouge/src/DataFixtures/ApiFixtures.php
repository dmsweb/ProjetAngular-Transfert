<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApiFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
            
           $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $profil= new Profil();
        $profil->setLibelle('AdminSupp');
        $manager->persist($profil);
        $manager->flush();

        $profil= new Profil();
        $profil->setLibelle('Admin');
        $manager->persist($profil);
        $manager->flush();


        $profil= new Profil();
        $profil->setLibelle('Caisier');
        $manager->persist($profil);
        $manager->flush();


        $user= new User();
        $user->setNomComplet('Ousmane Dieng');
        $user->setLogin('AdminSupp');
        $user->setProfil($profil);
        $user->setUsername('ousmane');
        $password= $this->encoder->encodePassword($user, 'admin123');
        $user->setPassword($password);
        $user->setRoles(array('ROLE_ADMIN_SYSTEM'));
        $user->setIsActive(true);
        $manager->persist($user);

       
        $manager->persist($user);
        $manager->flush();
          // $product = new Product();
    }
}
