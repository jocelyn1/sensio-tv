<?php

namespace App\Omdb;

use App\Entity\Movie;

class MovieApi implements MovieApiInterface
{
    private $apiClient;

    public function __construct(OmdbApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function get(string $id): Movie
    {
        return Movie::createFromApi($this->apiClient->requestById($id));
    }

    public function search(string $term): array
    {
        return $this->apiClient->requestBySearch($term);
    }
}
