<?php

namespace App;

use App\controllers\HomeController;
use App\controllers\TaskController;
use App\Repositories\TaskRepository;
use Framework\ResponseFactory;
use Framework\ServiceContainer;
use Framework\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container): void
    {
        $responseFactory = $container->get(ResponseFactory::class);

        $homeController = new HomeController($responseFactory);
        // Passing through an instance of and type
        $container->set(HomeController::class, $homeController);

        $taskRepository = new TaskRepository();
        $taskController = new TaskController($responseFactory, $taskRepository);
        $container->set(TaskController::class, $taskController);
    }
}
