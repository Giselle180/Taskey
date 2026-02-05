<?php

namespace App\controllers;

// Import
use Framework\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response("Welcome to Taskey");
    }

    public function about(): Response
    {
        return new Response("Taskey is Awesome");
    }
}
