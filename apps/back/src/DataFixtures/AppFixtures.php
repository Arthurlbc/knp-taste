<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User('admin@admin.fr','administrator');
        $password = $this->hasher->hashPassword($user, '$passw0rd_7634');
        $user->setPassword($password);

        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $courses = new Courses();
            $courses->setName('name: ' . $i);
            $courses->setVideo('video: ' . $i);
            $manager->persist($courses);
        }
        $manager->flush();
    }
}
