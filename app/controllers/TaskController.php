<?php

namespace App\controllers;

use Framework\Response;
use Framework\ResponseFactory;

class TaskController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function index(): Response
    {
        $response = $this->responseFactory->body("List all tasks");
        return $response;
    }

    public function create(): Response
    {
        $response = $this->responseFactory->body("Create new task");
        return $response;
    }
}
