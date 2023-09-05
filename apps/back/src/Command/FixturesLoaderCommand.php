<?php

namespace App\Command;

use App\Entity\Courses;
use App\Service\CoursesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesLoaderCommand extends Command
{

    private CoursesService $coursesService;

    public function __construct(CoursesService $coursesService, string $name = null)
    {
        parent::__construct($name);
        $this->coursesService = $coursesService;
    }

    protected function configure(): void
    {
        $this->setName('app:fixture:load');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        exec('php bin/console doctrine:schema:drop --force');
        exec('php bin/console doctrine:schema:create');
        for ($i = 0; $i < 10; $i++) {
            $courses = new Courses();
            $courses->setName('Courses: ' . $i);
            $courses->setVideo('Video:' . $i);
            $this->coursesService->add($courses);
        }
        return 1;
    }
}