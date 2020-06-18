<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('@html/index.html');
    }

    /**
     * @Route("/contact", name="app_main_contact", methods={"GET"})
     */
    public function contact(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/contact.html'));
    }

    /**
     * @Route("/login", name="app_main_login", methods={"GET"})
     */
    public function login(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/login.html'));
    }

    /**
     * @Route("/trailer-player", name="app_main_trailer_player", methods={"GET"})
     */
    public function trailerPlayer(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../html/trailer-player.html'));
    }
}
