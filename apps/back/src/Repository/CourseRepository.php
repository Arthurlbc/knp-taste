<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CourseRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function add(Course $courses, bool $flush): void
    {
        $this->_em->persist($courses);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function unpublish(Course $course): void
    {
        $course->setPublished(false);
        $this->_em->flush();
    }


    public function addReport(Course $courses): void
    {
        $courses->addReport();
        $this->_em->flush();
    }
}
