<?php

namespace Framework;

class Request
{
    public string $method;

    public string $path;

    /** @var string[] */
    public array $queryParameters;

    // You can also write like this
    /** @var array<string> */
    public array $postParameters;

    /**
     * @param string $method
     * @param string $path
     * @param string[] $queryParameters
     * @param string[] $postParameters
     */
    public function __construct(string $method, string $path, array $queryParameters, array $postParameters)
    {
    $this->methond = $method;
    $this->path = $path;
    $this->queryParameters = $queryParameters;
    $this->postParameters = $postParameters;
    }
}