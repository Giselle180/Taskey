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
        $matchedRoute = null;
        foreach ($this->routes as $route) {
            if ($route->matches($request->method, $request->path)) {
                $matchedRoute = $route;
                break;
            }
        }
        if ($matchedRoute === null) {
            // Route not found, return 404
            return new Response("Page not found", 404);
        }
        $response = new Response($matchedRoute->return);
        return $response;
    }

    public function addRoute(string $method, string $path, string $return): void
    {
        $this->routes[] = new Route($method, $path, $return);
    }
}
