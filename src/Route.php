<?php

namespace Framework;

class Route
{
    public string $method;

    public string $path;

    // You have to define callables this way
    /** @var callable */
    public $callback;

    /** @var string[] */
    public array $routeParameters;

    /**
     * @param string $method
     * @param string $path
     * @param callable $callback
     */
    public function __construct(string $method, string $path, callable $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function matches(string $method, string $path): bool
    {
        // Verifies if the method and path are the same
        if ($this->method !== $method) {
                return false;
        }

        // using regex to confirm the path is matched correctly for the url
        // Specific code input
        $pattern = ';^' . $this->path . '/?$;';
        if (preg_match($pattern, $path, $matches)) {
            $this->routeParameters = $matches;
            return true;
        }
            return false;
    }
}
