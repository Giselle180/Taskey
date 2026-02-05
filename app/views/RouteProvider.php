<?php

namespace App\views;

use App\controllers\HomeController;
use App\controllers\TaskController;
use Framework\RouteProviderInterface;
use Framework\Router;

// This class extends to Interface
class RouteProvider implements RouteProviderInterface
{
    public function register(Router $router): void
    {
        // Getting the callback function
        $homeController = new HomeController();
        // Define some routes from home control
        $router->addRoute("GET", "/", [$homeController, "index"]);
        $router->addRoute("GET", "/about", [$homeController, "about"]);
        // Define some routes from task control
        $taskController = new TaskController();
        $router->addRoute("GET", "/tasks", [$taskController, "index"]);
        $router->addRoute("GET", "/tasks/create", [$taskController, "create"]);
    }
}
