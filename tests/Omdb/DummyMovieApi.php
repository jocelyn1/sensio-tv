<?php

namespace App\Tests\Omdb;

use App\Entity\Movie;
use App\Omdb\MovieApiInterface;

class DummyMovieApi implements MovieApiInterface
{
    public function get(string $id): Movie
    {
        $movie = new Movie();
        $movie->setTitle('Dummy movie');
        $movie->setDescription('This is a fake movie for tests.');
        $movie->setDate(\DateTimeImmutable::createFromFormat('Y-m-d', '2020-05-24'));

        return $movie;
    }
}
