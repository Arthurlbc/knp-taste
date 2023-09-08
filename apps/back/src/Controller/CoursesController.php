<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Form\CoursesType;
use App\Repository\CoursesRepository;
use App\Service\CoursesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{

    public function __construct(private readonly CoursesRepository $coursesRepository, private readonly CoursesService $coursesService)
    {
    }

    #[Route(path: '/courses/index', name: 'app_courses_index')]
    public function index(): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }

        $user = $this->getUser();
        $day = $this->getParameter('time_to_wait_for_watching_courses_full');
        $isAuthorize = $this->coursesService->isAuthorize($user, $day);

        $courses = $this->coursesService->displayCoursesUser($user, $day);

        return $this->render('courses/index.html.twig', [
            'courses' => $courses,
            'isAuthorize' => $isAuthorize
        ]);

    }

    #[Route(path: '/courses/{id}', name: 'app_courses_detail')]
    public function coursesDetail(string $id): Response
    {
        $this->getUser()->addCourseViewed();
        $course = $this->coursesRepository->findOneBy(['id' => $id]);
        $iframe = $this->coursesService->getIframe($course->getVideo());

        return $this->render('courses/detail.html.twig', [
            'course' => $course,
            'iframe' => $iframe,
        ]);
    }

    #[Route(path: '/add', name: 'app_courses_add')]
    public function add(Request $request, RateLimiterFactory $createCourseLimiter): Response
    {
        $limiter = $createCourseLimiter->create($this->getUser()->getUserIdentifier());

        $form = $this->createForm(CoursesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course = new Courses($form->get('name')->getData(), $form->get('video')->getData());
            $this->coursesRepository->add($course, true);
            return $this->redirectToRoute('app_courses_index');
        }
        if (false === $limiter->consume(1)->isAccepted()) {
            $this->addFlash('warning',
                "You have to wait: " .
                $limiter->consume()->getRetryAfter()->format('Y-m-d H:i:s') .
                " before you can add a course.");
            return $this->redirectToRoute('app_courses_index');
        }
        return $this->render('courses/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/report-course/{id}',name: 'app_courses_report')]
    public function reportCourse(Request $request): Response
    {
        $course = $this->coursesRepository->findOneBy(['id' => $request->get('id')]);
        $this->coursesService->addReport($course);

        $this->addFlash('success', 'Course reported, thank\'s ! ');
        return $this->redirectToRoute('app_courses_index');
    }

    #[Route(path: '/remove-course/{id}', name: 'app_courses_remove')]
    public function remove(string $id): Response
    {
        $course = $this->coursesRepository->findOneBy(['id' => $id]);
        $this->coursesRepository->remove($course);

        $this->addFlash('success', 'Course removed');

        return $this->redirectToRoute('app_admin');
    }
}
