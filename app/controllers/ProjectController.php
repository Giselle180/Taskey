<?php

namespace App\controllers;

use App\models\Task;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use DateTime;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class ProjectController
{
    private $responseFactory;

    private $ProjectRepository;

    public function __construct(ResponseFactory $responseFactory, TaskRepository $taskRepository, ProjectRepository $projectRepository)
    {
        $this->responseFactory = $responseFactory;
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    public function index(): Response
    {
        $tasks = $this->ProjectRepository->all();
        return $this->responseFactory->view("projects/index.html.twig", ['projects' => $projects]);
    }

    public function create(): Response
    {
        return $this->responseFactory->view("projects/create.html.twig", []);
    }

    public function show(Request $request): Response
    {
        $projectId = (int)$request->get('id');
        $project = $this->taskRepository->find($projectId);

        if ($project == null) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->view("project/show.html.twig", ['project' => $project,]);
    }

    public function store(Request $request): Response
    {
        $title = $request->get('title');
        $description = $request->get('description');

        $errors = array();
        if ($title === null || $title === '') {
            $errors['title'] = "Title is required";
        }

        if ($description === null || $description === '') {
            $errors['description'] = "Description is required";
        }

        if (!empty($errors)) {
            return $this->responseFactory->view("project/create.html.twig", [
                'errors' => $errors,
            ]);
        }

        $task = new Task();
        $task->title = (string)$title;
        $task->description = (string)$description;

        $project = $this->taskRepository->insert($project);
        if ($project == null) {
            return $this->responseFactory->internalError();
        }

        return $this->responseFactory->redirect('/project' .$project->id);
    }

    public function edit(Request $request): Response
    {
        $projectId = (int)$request->get('id');
        $project = $this->taskRepository->find($projectId);
        return $this->responseFactory->view("project/edit.html.twig", [
            'project' => $project,
        ]);
    }

    public function update(Request $request): Response
    {
        $projectId = (int)$request->get('id');
        $project = $this->taskRepository->find($projectId);

        if (!$project) {
            return $this->responseFactory->notFound();
        }

        $project->title = (string)$request->get('title') ?? $project->title;
        $project->description = (string)$request->get('description') ?? $project->description;


        $projectUpdate = $this->taskRepository->update($project);
        if ($projectUpdate) {
            return $this->responseFactory->internalError();
        }
        return $this->responseFactory->redirect('/project/create/html.twig' . $project->id);
    }

    public function deleteConfirm(Request $request): Response
    {
        $projectId = (int)$request->get('id');
        $project = $this->taskRepository->find($projectId);
        if (!$project) {
            return $this->responseFactory->notFound();
        }
        return $this->responseFactory->view('project/delete.html.twig', [
            'project' => $project
        ]);
    }

    public function delete(Request $request): Response
    {
        $projectId = (int)$request->get('id');
        $project = $this->taskRepository->find($projectId);

        if (!$project) {
            return $this->responseFactory->notFound();
        }

        $this->taskRepository->delete($project);
        return $this->responseFactory->redirect('/projects');
    }
}
