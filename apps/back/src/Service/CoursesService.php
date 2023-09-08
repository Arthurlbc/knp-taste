<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\CoursesRepository;
use DateTime;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CoursesService
{

    public function __construct(private readonly CoursesRepository $coursesRepository, private readonly AuthorizationCheckerInterface $authorizationChecker)
    {
    }


    public function displayCoursesUser(User $user, int $day): array
    {
        $courses = $this->coursesRepository->findAll();
        if (true === $this->authorizationChecker->isGranted('ROLE_ADMIN') || $user->getVideoViewed() > 9 || $this->checkAwaitingTime($user, $day)) {
            return $courses;
        }
        array_walk($courses, function ($value) {
            $value->setVideo('Hidden');
        });
        return $courses;
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

}