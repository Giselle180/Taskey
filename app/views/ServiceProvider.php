<?php

namespace App\views;

use App\controllers\HomeController;
use App\controllers\TaskController;
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

        $taskController = new TaskController($responseFactory);
        $container->set(TaskController::class, $taskController);
    }
}
