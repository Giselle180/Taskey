<?php

namespace App\controllers;

use App\models\Task;
use App\Repositories\TaskRepository;
use DateTime;
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

    public function index(): Response
    {
        $tasks = $this->taskRepository->all();
        return $this->responseFactory->view("tasks/index.html.twig", ['tasks' => $tasks]);
    }

    public function create(): Response
    {
        return $this->responseFactory->view("tasks/create.html.twig", []);
    }

    public function show(Request $request): Response
    {
        $taskId = (int)$request->get('id');
        $task = $this->taskRepository->find($taskId);

        if ($task == null) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->view("tasks/show.html.twig", ['task' => $task,]);
    }

    public function store(Request $request): Response
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $priority = $request->get('priority');
        $status = $request->get('status');
        $createdAt = DateTime::createFromFormat('Y-m-d', $request->get('created_at'));

        $errors = array();
        if ($title === null || $title === '') {
            $errors['title'] = "Title is required";
        }

        if ($description === null || $description === '') {
            $errors['description'] = "Description is required";
        }

        if ((is_numeric($priority))) {
            $errors['priority'] = "Priority must be a number";
        }

        if ((is_numeric($status))) {
            $errors['status'] = "Status must be a number";
        }

        if (!$createdAt) {
            $createdAt = date('%s');
        } else {
            $createdAt = $createdAt->getTimestamp();
        }

        if (!empty($errors)) {
            return $this->responseFactory->view("tasks/create.html.twig", [
                'errors' => $errors,
            ]);
        }

        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->priority = (int)$priority;
        $task->status = (int)$status;
        $task->createdAt = (int)$createdAt;

        $task = $this->taskRepository->insert($task);
        if ($task == null) {
            return $this->responseFactory->internalError();
        }

        return $this->responseFactory->redirect('/tasks' . $task->id);
    }
}
