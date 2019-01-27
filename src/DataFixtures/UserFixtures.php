<?php
/**
 * Created by PhpStorm.
 * User: anru
 * Date: 27-Jan-19
 * Time: 3:24 PM
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
          $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        try {
            $user = new User();
            $user->setEmail('meme@gmail.com');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                '123456'));

            $manager->persist($user);
            $manager->flush();
        } catch (\Exception $e) {
            dump($e);
        }
    }
}