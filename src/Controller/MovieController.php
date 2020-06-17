<?php

namespace App\Controller;

use App\Omdb\MovieApiInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/by-genre/{genre}", name="app_movie_list_by_genre", methods={"GET"})
     */
    public function listByGenre(string $genre = 'comedy'): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/movie-by-genre.html'));
    }

    /**
     * @Route("/details/{id}", name="app_movie_show_details", methods={"GET"})
     */
    public function showDetails(string $id = 'tt1285016', MovieApiInterface $movieApi): Response
    {
        return $this->render('movie/show_details.html.twig', [
            'movie' => $movieApi->get($id),
        ]);
    }

    /**
     * @Route("/latest", name="app_movie_latest", methods={"GET"})
     */
    public function latest(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/movie-latest.html'));
    }

    /**
     * @Route("/player", name="app_movie_player", methods={"GET"})
     */
    public function player(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/movie-player.html'));
    }

    /**
     * @Route("/top-rated", name="app_movie_top_rated", methods={"GET"})
     */
    public function topRated(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/movie-top-rated.html'));
    }
}
