<?php

namespace spec\App\Entity;

use App\Entity\Courses;
use PhpSpec\ObjectBehavior;

class CoursesSpec extends ObjectBehavior
{

    function let(): void
    {
        $this->beConstructedWith('name', 'https://www.youtube.com/watch?v=kUMe1FH4CHE');
    }

    function it_is_initializable(): void
    {

        $this->shouldBeAnInstanceOf(Courses::class);
    }

    function it_should_have_url_format(): void
    {
        $this->getVideo()->shouldNotContain('www.youtube.com/watch?v=');
        $this->getVideo()->shouldNotContain('youtu.be/');
        $this->getVideo()->shouldContain('www.youtube.com/embed/');
    }
}