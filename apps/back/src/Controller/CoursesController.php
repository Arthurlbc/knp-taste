<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Service\CourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{

    public function __construct(private readonly CourseRepository $coursesRepository, private readonly CourseService $coursesService)
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
        $isAuthorize = $this->coursesService->isAuthorized($user, $day);

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

        $form = $this->createForm(CourseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course = new Course($form->get('name')->getData(), $form->get('video')->getData());
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

    #[Route(path: '/report-course/{id}', name: 'app_courses_report')]
    public function reportCourse(Request $request): Response
    {
        $course = $this->coursesRepository->findOneBy(['id' => $request->get('id')]);
        $this->coursesRepository->addReport($course);

        $this->addFlash('success', 'Course reported, thank\'s ! ');
        return $this->redirectToRoute('app_courses_index');
    }

    #[Route(path: '/unpublished-course/{id}', name: 'app_courses_unpublish')]
    public function remove(string $id): Response
    {
        $course = $this->coursesRepository->findOneBy(['id' => $id]);
        $this->coursesRepository->unpublish($course);

        $this->addFlash('success', 'Course unpublished');

        return $this->redirectToRoute('app_admin');
    }
}
