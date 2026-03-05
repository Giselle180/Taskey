<?php

namespace App;

use App\controllers\HomeController;
use App\controllers\TaskController;
use Framework\RouteProviderInterface;
use Framework\Router;
use Framework\ServiceContainer;

// This class extends to Interface
class RouteProvider implements RouteProviderInterface
{
    public function register(Router $router, ServiceContainer $container): void
    {
        // Getting the callback function
        $homeController = $container->get(HomeController::class);
        // Define some routes from home control
        $router->addRoute("GET", "/", [$homeController, "index"]);
        $router->addRoute("GET", "/about", [$homeController, "about"]);

        // Define some routes from task control
        $taskController = $container->get(TaskController::class);
        $router->addRoute("GET", "/tasks", [$taskController, "index"]);
        // or (\d+) for regex digit
        $router->addRoute("GET", '/tasks/(?<id>[0-9]+)', [$taskController, "show"]);
        $router->addRoute("GET", "/tasks/create", [$taskController, "create"]);
        $router->addRoute("POST", "/tasks", [$taskController, "store"]);

        $router->addRoute('GET', '/tasks/(?<id>\d+)/edit', [$taskController, 'edit']);
        $router->addRoute('POST', '/tasks/(?<id>\d+)/edit', [$taskController, 'update']);
        $router->addRoute('GET', '/tasks/(?<id>\d+)/delete', [$taskController, 'deleteConfirm']);
        $router->addRoute('POST', '/tasks/(?<id>\d+)/delete', [$taskController, 'delete']);
    }
}
