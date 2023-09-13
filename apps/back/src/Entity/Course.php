<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $name;
    #[ORM\Column(type: 'string', length: 180, unique: false)]
    private string $video;

    #[ORM\Column(type: 'integer')]
    private int $reportNumber;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $published;

    public function __construct(string $name, string $video)
    {
        $this->name = $name;
        $this->setVideo($video);
        $this->reportNumber = 0;
        $this->published = true;
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
        $video = $this->cleanUrl($video);
        $this->video = $video;
    }

    private function cleanUrl($youtubeURL)
    {
        if (!empty($youtubeURL && strstr($youtubeURL, 'youtube'))) {
            $youtubeURL = str_replace('youtu.be/', 'www.youtube.com/embed/', $youtubeURL);
            $youtubeURL = str_replace('www.youtube.com/watch?v=', 'www.youtube.com/embed/', $youtubeURL);
        } else {
            return 'invalid_url';
        }
        // -----------------
        return $youtubeURL;
    }

    public function addReport()
    {
        $this->reportNumber++;
    }

    public function getReportNumber(): int
    {
        return $this->reportNumber;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

}
