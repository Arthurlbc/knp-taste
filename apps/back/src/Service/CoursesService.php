<?php

namespace App\Service;

use App\Entity\Courses;
use App\Repository\CoursesRepository;

class CoursesService
{

    public function __construct(private readonly CoursesRepository $coursesRepository)
    {
    }

    public function getAll(): array
    {
        return $this->coursesRepository->findAll();
    }

    public function add(Courses $courses)
    {
//        $courses = new Courses();
//        $courses->setName($formData['name']);
//        $courses->setVideo($formData['video']);
        // TODO make constraint if name is unique for example
        $this->coursesRepository->add($courses, true);
    }

}