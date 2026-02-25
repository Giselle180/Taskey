<?php

namespace App\controllers;

use App\Repositories\TaskRepository;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class TaskController
{
    private ResponseFactory $responseFactory;

    // Interface
    private TaskRepository $taskRepository;

    public function __construct(ResponseFactory $responseFactory, TaskRepository $taskRepository)
    {
        $this->responseFactory = $responseFactory;
        $this->taskRepository = $taskRepository;
    }

    public function show(Request $request): Response
    {
        $task = $request->get('id');

        if ($task == null) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->view("tasks/show.html.twig", ['id' => $task,]);
    }

    public function index(): Response
    {
        return $this->responseFactory->view("tasks/index.html.twig", []);
    }

    public function create(): Response
    {
        return $this->responseFactory->view("tasks/create.html.twig", []);
    }
}
