<?php

namespace Framework;

class Kernel
{
    private Router $router;

    private ServiceContainer $container;

    private ConfigManager $configManager;

    /**
     * @param string[] $config
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        // Crates router
        $this->container = new ServiceContainer();

        $this->configManager = new ConfigManager($config);

        $debugMode = $this->configManager->get('APP_ENV') === 'development';
        $viewPath = $this->configManager->get('VIEWS_PATH');
        // Added it here so it's accessible anywhere
        $responseFactory = new ResponseFactory($viewPath, $debugMode);
        $this->container->set(ResponseFactory::class, $responseFactory);

        $dbName = $this->configManager->get('APP_DB');
        $database = new Database(__DIR__ . '/../' . $dbName);
        $this->container->set(Database::class, $database);

        $this->router = new Router($responseFactory);
    }

    public function registerRoutes(RouteProviderInterface $routeProvider): void
    {
        $routeProvider->register($this->router, $this->container);
    }

    public function registerServices(ServiceProviderInterface $serviceProvider): void
    {
        $serviceProvider->register($this->container);
    }

    /**
     * Handle incoming Request and produce a Response
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        // Router will be dispatched
        return $this->router->dispatch($request);
    }

    public function getDatabase(): Database
    {
        return $this->container->get(Database::class);
    }
}
