<?php

namespace App\controllers;

use App\models\Task;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use DateTime;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class TaskController
{
    private ResponseFactory $responseFactory;

    private TaskRepository $taskRepository;

    private ProjectRepository $projectRepository;

    public function __construct(ResponseFactory $responseFactory, TaskRepository $taskRepository, ProjectRepository $projectRepository)
    {
        $this->responseFactory = $responseFactory;
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
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
        $progress = $request->get('progress');
        $createdAt = DateTime::createFromFormat('Y-m-d', $request->get('created_at'));
        $completedAt = DateTime::createFromFormat('Y-m-d', $request->get('complete_at'));

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

        if ((is_numeric($progress))) {
            $errors['progress'] = "Progress must be a number";
        }

        if (!$createdAt) {
            $createdAt = date('%s');
        } else {
            $createdAt = $createdAt->getTimestamp();
        }

        if (!$completedAt) {
            $completedAt = date('%s');
        } else {
            $completedAt = $completedAt->getTimestamp();
        }

        if (!empty($errors)) {
            return $this->responseFactory->view("tasks/create.html.twig", [
                'errors' => $errors,
            ]);
        }

        $task = new Task();
        $task->title = (string)$title;
        $task->description = (string)$description;
        $task->priority = (int)$priority;
        $task->status = (int)$status;
        $task->progress = (int)$progress;
        $task->createdAt = (int)$createdAt;
        $task->completedAt = (int)$completedAt;

        $task = $this->taskRepository->insert($task);
        if ($task == null) {
            return $this->responseFactory->internalError();
        }

        return $this->responseFactory->redirect('/tasks' . $task->id);
    }

    public function edit(Request $request): Response
    {
        $taskId = (int)$request->get('id');
        $task = $this->taskRepository->find($taskId);
        return $this->responseFactory->view("tasks/edit.html.twig", [
            'task' => $task,
            ]);
    }

    public function update(Request $request): Response
    {
        $taskId = (int)$request->get('id');
        $task = $this->taskRepository->find($taskId);

        if (!$task) {
            return $this->responseFactory->notFound();
        }

        $task->title = (string)$request->get('title') ?? $task->title;
        $task->description = (string)$request->get('description') ?? $task->description;
        $task->priority = (int)$request->get('priority');
        $task->status = (int)$request->get('status');
        $task->progress = (int)$request->get('progress');
        $task->createdAt = (int)$request->get('created_at');
        $task->completedAt = (int)$request->get('complete_at');

        if ($request->get('created_at')) {
            $created_at = DateTime::createFromFormat('Y-m-d', $request->get('created_at'));
            $task->createdAt = $created_at ? $created_at->getTimestamp() : (int)date('%s');
        }

        $completedAtInput = $request->get('completed_at');
        if ($completedAtInput) {
            $completedAt = DateTime::createFromFormat('Y-m-d', $completedAtInput);
            $task->completedAt = $completedAt ? $completedAt->getTimestamp() : null;
        }

        $taskUpdate = $this->taskRepository->update($task);
        if ($taskUpdate) {
            return $this->responseFactory->internalError();
        }
        return $this->responseFactory->redirect('/tasks/create/html.twig' . $task->id);
    }

    public function deleteConfirm(Request $request): Response
    {
        $taskId = (int)$request->get('id');
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            return $this->responseFactory->notFound();
        }
        return $this->responseFactory->view('tasks/delete.html.twig', [
            'task' => $task
        ]);
    }

    public function delete(Request $request): Response
    {
        $taskId = (int)$request->get('id');
        $task = $this->taskRepository->find($taskId);

        if (!$task) {
            return $this->responseFactory->notFound();
        }

        $this->taskRepository->delete($task);
        return $this->responseFactory->redirect('/tasks');
    }
}
