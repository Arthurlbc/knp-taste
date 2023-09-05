<?php

namespace App\Entity;

use App\Repository\CoursesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursesRepository::class)]
class Courses
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $name;
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $video;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getVideo(): string
    {
        return $this->video;
    }

    public function setVideo(string $video): void
    {
        $this->video = $video;
    }


}