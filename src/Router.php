<?php

namespace Framework;

class Router
{
    /** @var Route[]  */
    private array $routes;

    public function __construct()
    {
    }

    public function dispatch(Request $request): Response
    {
        // Compares the routes to see if they match
        $matchedRoute = null;
        foreach ($this->routes as $route) {
            if ($route->matches($request->method, $request->path)) {
                $matchedRoute = $route;
                break;
            }
        }
        // If it doesn't match anything then returns error
        if ($matchedRoute === null) {
            // Route not found, return 404
            return new Response("Page not found", 404);
        }
        // If it's all correct then it returns it
        $callback = $matchedRoute->callback;
        $response = $callback();
        return $response;
    }

    public function addRoute(string $method, string $path, callable $callback): void
    {
        $this->routes[] = new Route($method, $path, $callback);
    }
}
