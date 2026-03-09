<?php

namespace App;

use App\controllers\HomeController;
use App\Controllers\ProjectController;
use App\controllers\TaskController;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use Framework\Database;
use Framework\ResponseFactory;
use Framework\ServiceContainer;
use Framework\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container): void
    {
        $responseFactory = $container->get(ResponseFactory::class);

        $database = $container->get(Database::class);

        $taskRepository = new TaskRepository($database);
        $container->set(TaskRepositoryInterface::class, $taskRepository);

        $homeController = new HomeController($responseFactory);
        // Passing through an instance of and type
        $container->set(HomeController::class, $homeController);

        $taskController = new TaskController($responseFactory, $taskRepository, $projectRepository);
        $container->set(TaskController::class, $taskController);

        $projectController = new ProjectController($responseFactory, $projectRepository, $taskRepository);
        $container->set(ProjectController::class, $projectController);
    }
}
