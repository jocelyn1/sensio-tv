<?php

namespace App\Omdb;

use App\Entity\Movie;

interface MovieApiInterface
{
    public function get(string $id): Movie;
}
