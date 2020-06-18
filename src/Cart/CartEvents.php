<?php

namespace App\Cart;

class CartEvents
{
    /**
     * @Event("App\Cart\CartEvent")
     */
    public const ADD_MOVIE = 'cart.add_movie';
}
