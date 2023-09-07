<?php

namespace spec\App\Entity;

use App\Entity\User;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{

    function let(): void
    {
        $this->beConstructedWith('email', 'username');
    }

    function it_is_initializable(): void
    {

        $this->shouldBeAnInstanceOf(User::class);
    }

    function it_should_have_values_init(): void
    {
        $this->getEmail()->shouldBe('email');
        $this->getUsername()->shouldBe('username');
        $this->getRegisterAt()->shouldBeAnInstanceOf(DateTimeImmutable::class);
        $this->getVideoViewed()->shouldBe(0);
    }

}
