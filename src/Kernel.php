<?php

namespace Framework;

class Kernel
{
    private Router $router;

    private ServiceContainer $container;

    public function __construct()
    {
        // Crates router
        $this->container = new ServiceContainer();

        // Added it here so it's accessible anywhere
        $responseFactory = new ResponseFactory();
        $this->container->set(ResponseFactory::class, $responseFactory);

        $this->router = new Router($responseFactory);
    }

    public function handle(Request $request): Response
    {
        // Router will be dispatched
        return $this->router->dispatch($request);
    }

    public function registerRoutes(RouteProviderInterface $routeProvider): void
    {
        $routeProvider->register($this->router, $this->container);
    }

    public function registerServices(ServiceProviderInterface $serviceProvider): void
    {
        $serviceProvider->register($this->container);
    }
}
