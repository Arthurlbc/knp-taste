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

        $user = new User('admin@admin.fr', 'administrator');
        $password = $this->hasher->hashPassword($user, '$passw0rd_7634');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $courses = new Courses('Course: Javascript ', 'https://www.youtube.com/watch?v=SBmSRK3feww');
        $manager->persist($courses);
        $courses = new Courses('Course: Angular', 'https://www.youtube.com/watch?v=NMzl2pGOK_8&list=PL1BztTYDF-QNrtkvjkT6Wjc8es7QB4Gty');
        $manager->persist($courses);
        $courses = new Courses('Course: Html', 'https://www.youtube.com/watch?v=kUMe1FH4CHE');
        $manager->persist($courses);
        $courses = new Courses('Course: CSS', 'https://www.youtube.com/watch?v=OXGznpKZ_sA');
        $manager->persist($courses);
        $courses = new Courses('Course: Flutter', 'https://www.youtube.com/watch?v=VPvVD8t02U8');
        $manager->persist($courses);
        $courses = new Courses('Course: Php', 'https://www.youtube.com/watch?v=zZ6vybT1HQs');
        $manager->persist($courses);

        $manager->flush();
    }
}
