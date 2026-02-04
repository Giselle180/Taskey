<?php

namespace Framework;

class Kernel
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }


    // You don't have to import bc they're in the same name space
    public function handle(Request $request): Response
    {
        return $this->router->dispatch($request);
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}
