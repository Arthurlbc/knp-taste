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

    public function findAllInArray()
    {
        return $this->createQueryBuilder('courses')
            ->getQuery()->getArrayResult();
    }

    public function remove(Course $courses): void
    {
        $this->_em->remove($courses);
        $this->_em->flush();
    }


    public function addReport(Course $courses): void
    {
        $courses->addReport();
        $this->_em->flush();
    }
}
