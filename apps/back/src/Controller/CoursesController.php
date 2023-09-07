<?php

namespace App\Controller;

use App\Form\CoursesType;
use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{

    public function __construct(private readonly CoursesRepository $coursesRepository)
    {
    }

    #[Route(path: '/courses/index', name: 'app_courses_index')]
    public function index(Request $request): Response
    {
        $courses = $this->coursesRepository->findAll();

        return $this->render('courses/index.html.twig', [
            'courses' => $courses
        ]);

    }

    #[Route(path: '/courses/add', name: 'app_courses_add')]
    public function add(Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(CoursesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->coursesRepository->add($form->getData(), true);
            return $this->redirectToRoute('app_courses_index');
        }

        return $this->render('courses/add.html.twig', [
            'form' => $form,
        ]);
    }
}
