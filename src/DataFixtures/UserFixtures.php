<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("jj.nunezmartin@gmail.com");
        $roles = array('ROLE_ADMIN');
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             '123456'
         ));
        $user->setWorkgroup("GROUP_ADMIN");

        $manager->persist($user);

        $manager->flush();

        $user = new User();
        $user->setEmail("javi_lanzarote@hotmail.com");
        $roles = array('ROLE_USER');
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             '123456'
         ));
        $user->setWorkgroup("GROUP_JAVI");

        $manager->persist($user);

        $manager->flush();
    }
}
