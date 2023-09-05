<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $courses = new Courses();
        $courses->setName('my first courses');
        $courses->setVideo('www.youtube/vidéo-courses.com');


        $manager->persist($courses);
        $manager->flush();
    }
}
