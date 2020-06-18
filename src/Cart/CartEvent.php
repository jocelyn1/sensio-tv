<?php

namespace App\Cart;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class CartEvent extends Event
{
    private $user;
    private $movie;

    public function __construct(User $user, Movie $movie)
    {
        $this->user = $user;
        $this->movie = $movie;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }
}
