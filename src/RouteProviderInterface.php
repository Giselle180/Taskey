<?php

namespace Framework;

// Abstract class
interface RouteProviderInterface
{
    public function register(Router $router, ServiceContainer $container): void;
}
