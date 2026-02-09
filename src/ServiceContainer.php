<?php

namespace Framework;

use Exception;

// It helps with things that provide functionality
class ServiceContainer
{
    // Group of string
    /** @var array<class-string, object> */
    private array $instances = [];

    // The class-string needs an object held inside
    /**
     * @template T of object
     * @param class-string<T> $id
     * @param object $instance
     * @throws Exception
     */
    public function set(string $id, object $instance): void
    {
        // Specific code input
        // Stop the function at that specific if
        if (isset($this->instances[$id])) {
            // Then shows the error on phpstan as debug method
            throw new Exception("Target binding [$id] already exists.");
        }
        $this->instances[$id] = $instance;
    }

    /**
     * @template T of object
     * @param class-string<T> $id
     * @return T
     * @throws Exception
     */
    public function get(string $id): object
    {
        if (!isset($this->instances[$id])) {
            throw new Exception("Target binding [$id] does not exist.");
        }

        /** @var T */
        return $this->instances[$id];
    }
}
