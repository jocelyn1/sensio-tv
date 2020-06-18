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

    public function search(string $term): array
    {
        return [
            'Search' => [
                [
                    "Title" => "Toto the Hero",
                    "Year" => "1991",
                    "imdbID" => "tt0103105",
                    "Type" => "movie",
                    "Poster" => "https://m.media-amazon.com/images/M/MV5BMjAzMjAyNjE0OV5BMl5BanBnXkFtZTcwOTMyOTI0MQ@@._V1_SX300.jpg",
                ]
            ],
            'totalResults' => 1,
            'Response' => 'true',
        ];
    }
}
