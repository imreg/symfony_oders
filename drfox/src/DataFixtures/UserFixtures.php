<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.com');

        $encodedPassword = $this->passwordHasher->hashPassword($user, 'secret');
        $user->setPassword($encodedPassword);
        $user->setCreated(new \DateTimeImmutable());
        $user->setUpdated(new \DateTimeImmutable());
        $manager->persist($user);

        $manager->flush();
    }
}
