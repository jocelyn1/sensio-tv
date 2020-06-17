<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoutingTest extends WebTestCase
{
    /**
     * @dataProvider provideRoutes
     */
    public function testIndex(string $url, int $statusCode, string $title)
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseStatusCodeSame($statusCode);
        $this->assertSelectorTextSame('title', $title);
    }

    public function provideRoutes(): iterable
    {
        yield 'Route app_main_index' => ['/', Response::HTTP_OK, 'SensioTV - Home'];
        yield 'Route app_main_contact' => ['/contact', Response::HTTP_OK, 'SensioTV - Contact'];
        yield 'Route app_main_login' => ['/login', Response::HTTP_OK, 'SensioTV - Log In'];
        yield 'Route app_main_trailer_player' => ['/trailer-player', Response::HTTP_OK, 'SensioTV - Trailer Player'];
        yield 'Route app_movie_list_by_genre' => ['/movie/by-genre', Response::HTTP_OK, 'SensioTV - Movies By Genre'];
        yield 'Route app_movie_show_details' => ['/movie/details', Response::HTTP_OK, 'SensioTV - Dummy movie Details'];
        yield 'Route app_movie_latest' => ['/movie/latest', Response::HTTP_OK, 'SensioTV - Latest Movies'];
        yield 'Route app_movie_player' => ['/movie/player', Response::HTTP_OK, 'SensioTV - Movie Player'];
        yield 'Route app_movie_top_rated' => ['/movie/top-rated', Response::HTTP_OK, 'SensioTV - Top Rated Movies'];
        yield 'Route app_user_register' => ['/register', Response::HTTP_OK, 'SensioTV - Registration'];
        yield 'Route app_user_recover_password' => ['/password-recovering', Response::HTTP_OK, 'SensioTV - Password Recovery'];
        yield 'Route app_user_cart' => ['/user-cart', Response::HTTP_OK, 'SensioTV - Shopping cart'];
        yield 'Route app_user_profile' => ['/user-profile', Response::HTTP_OK, 'SensioTV - My Account'];
        yield 'Route app_user_watchlist' => ['/user-watchlist', Response::HTTP_OK, 'SensioTV - My Watchlist'];
    }
}
