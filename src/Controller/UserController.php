<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Security\Voter\AddMovieToCartVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="app_user_register", methods={"GET"})
     */
    public function register(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/register.html'));
    }

    /**
     * @Route("/password-recovering", name="app_user_recover_password", methods={"GET"})
     */
    public function recoverPassword(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/password-recovering.html'));
    }

    /**
     * @Route("/user-cart", name="app_user_cart", methods={"GET"})
     */
    public function cart(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/user-cart.html'));
    }


    /**
     * @IsGranted(AddMovieToCartVoter::CAN, subject="movie")
     * @Route("/user-cart/add-movie/{id}", name="app_user_add_movie_to_cart", methods={"GET"})
     */
    public function addMovieToCart(Movie $movie): Response
    {
        $this->isGranted(AddMovieToCartVoter::CAN, $movie);
        //
        // UserCart::addMovie($movie, $this->getUser())
        return new Response(file_get_contents(__DIR__.'/../../html/user-cart.html'));
    }

    /**
     * @Route("/user-profile", name="app_user_profile", methods={"GET"})
     */
    public function profile(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/user-profile.html'));
    }

    /**
     * @Route("/user-watchlist", name="app_user_watchlist", methods={"GET"})
     */
    public function watchlist(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/user-watchlist.html'));
    }
}
