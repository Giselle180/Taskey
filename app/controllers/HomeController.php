<?php

namespace App\controllers;

// Import
use Framework\Response;
use Framework\ResponseFactory;

class HomeController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function index(): Response
    {
        $response = $this->responseFactory->body("Home Page");
        return $response;
    }

    public function about(): Response
    {
        $response = $this->responseFactory->body("About Page");
        return $response;
    }
}
