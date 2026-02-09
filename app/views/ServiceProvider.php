<?php

namespace App\views;

use App\controllers\HomeController;
use App\controllers\TaskController;
use Framework\ServiceContainer;
use Framework\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container): void
    {
        $homeController = new HomeController();
        // Passing through an instance of and type
        $container->set(HomeController::class, $homeController);

        $taskController = new TaskController();
        $container->set(TaskController::class, $taskController);
    }
}
