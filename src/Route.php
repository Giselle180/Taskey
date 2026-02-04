<?php

namespace Framework;

class Route
{
    public string $method;

    public string $path;

    public string $return;

    public function __construct(string $method, string $path, string $return)
    {
        $this->method = $method;
        $this->path = $path;
        $this->return = $return;
    }

    public function matches(string $method, string $path): bool
    {
        // Verifies if the method and path are the same
        return $this->method === $method && $this->path === $path;
    }
}
