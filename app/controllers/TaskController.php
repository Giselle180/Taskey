<?php

namespace App\controllers;

use Framework\Response;

class TaskController
{
    public function index(): Response
    {
        return new Response("Listing all the tasks");
    }

    public function create(): Response
    {
        return new Response("Create a new task");
    }
}
