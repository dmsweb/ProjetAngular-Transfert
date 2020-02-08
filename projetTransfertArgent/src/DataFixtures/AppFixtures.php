<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
            
           $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $profile1= new Profile();
        $profile1->setLibelle('ROLE_SUPER_ADMIN');
        $manager->persist($profile1);
        $manager->flush();
        //
        $profile2= new Profile();
        $profile2->setLibelle('ROEL_ADMIN');
        $manager->persist($profile2);
        //
        $profile3= new Profile();
        $profile3->setLibelle('ROLE_CAISSIER');
        $manager->persist($profile3);
        //
        $profile4= new Profile();
        $profile4->setLibelle('ROLE_PARTENAIRE');
        $manager->persist($profile4);
        

        $user= new User();
        $user->setLogin('diengkorrou88@gmail.com');
        $user->setProfile($profile1);
        $user->setUsername('ousmane');
        $password= $this->encoder->encodePassword($user, 'admin123');
        $user->setPassword($password);
        $user->setIsActive(true);
        $manager->persist($user);

       
        $manager->persist($user);
        $manager->flush();
          // $product = new Product();
    }
}