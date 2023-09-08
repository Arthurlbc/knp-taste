<?php

namespace App\Service;

use App\Entity\Courses;
use App\Entity\User;
use App\Repository\CoursesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CoursesService
{

    public function __construct(private readonly CoursesRepository             $coursesRepository,
                                private readonly AuthorizationCheckerInterface $authorizationChecker,
                                private readonly EntityManagerInterface        $entityManager
    )
    {
    }

    public function addReport(Courses $courses): void
    {
        $courses->addReport();
        $this->entityManager->flush();
    }

    public function displayCoursesUser(User $user, int $day): array
    {
        $courses = $this->coursesRepository->findAll();

        if ($this->isAuthorize($user, $day)) {
            return $courses;
        }
        array_walk($courses, function ($value) {
            $value->setVideo('Hidden');
        });

        return $courses;
    }

    public function isAuthorize(User $user, int $day): bool
    {
        if (true === $this->authorizationChecker->isGranted('ROLE_ADMIN') || $user->getVideoViewed() > 9 || $this->checkAwaitingTime($user, $day)) {
            return true;
        }
        return false;
    }

    private function checkAwaitingTime(User $user, int $day): bool
    {
        $now = new DateTime('NOW');
        $date = $now->modify('-' . $day);
        if ($user->getRegisterAt() > $date) {
            return true;
        }
        return false;
    }

    function getIframe($urlVideo): string
    {
        $video_iframe = '';
        // -----------------
        if (!empty($urlVideo)) {
            $video_iframe = '<iframe width="560" height="315" src="' . $urlVideo . '"  frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        }
        // -----------------
        return $video_iframe;
    }
}
