<?php

namespace Framework;

class Route
{
    public string $method;

    public string $path;

    // You have to define callables this way
    /** @var callable */
    public $callback;

    public function __construct(string $method, string $path, callable $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function matches(string $method, string $path): bool
    {
        // Verifies if the method and path are the same
        return $this->method === $method && $this->path === $path;
    }
}
