<?php

namespace App\Cart;

use App\Entity\Movie;
use App\Entity\User;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Security;

class UserCart
{
    private $security;
    private $dispatcher;

    public function __construct(Security $security, EventDispatcherInterface $dispatcher)
    {
        $this->security = $security;
        $this->dispatcher = $dispatcher;
    }

    public function addMovie(Movie $movie)
    {
        /** @var User $user */
//        $user = $this->security->getUser();

        $this->dispatcher->dispatch(new CartEvent($user, $movie), CartEvents::ADD_MOVIE);

        return $this->doAddMovie($this->security->getUser(), $movie);
    }

    private function doAddMovie(User $user, Movie $movie)
    {

    }
}
