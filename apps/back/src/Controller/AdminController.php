<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function __construct(private readonly CourseRepository $coursesRepository)
    {
    }

    #[Route(path: '/admin', name: 'app_admin')]
    public function index(): Response
    {

        $courses = $this->coursesRepository->findAll();

        return $this->render('/admin/index.html.twig', [
            'courses' => $courses
        ]);
    }
}
