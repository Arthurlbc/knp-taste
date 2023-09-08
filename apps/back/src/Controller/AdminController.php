<?php

namespace App\Controller;

use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function __construct(private readonly CoursesRepository $coursesRepository)
    {
    }

    #[Route(path: '/admin', name: 'app_admin')]
    public function index()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_courses_index');
        }

        $courses = $this->coursesRepository->findAll();

        return $this->render('/admin/index.html.twig', [
            'courses' => $courses
        ]);
    }
}