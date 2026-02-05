<?php

namespace Framework;

class Kernel
{
    private Router $router;

    public function __construct()
    {
        // Crates router
        $this->router = new Router();
    }

    public function handle(Request $request): Response
    {
        // Router will be dispatched
        return $this->router->dispatch($request);
    }

    public function registerRoutes(RouteProviderInterface $routeProvider): void
    {
        $routeProvider->register($this->router);
    }
}
