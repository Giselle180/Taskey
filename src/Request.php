<?php

namespace Framework;

class Request
{
    // Chose between GET or POST
    public string $method;

    // What's written on the path
    public string $path;

    // Something for later
    // Always have to assign what kind of array it is
    /** @var string[] */
    public array $queryParameters;

    // You can also write like this
    /** @var array<string> */
    public array $postBody;

    /**
     * @param string $method
     * @param string $path
     * @param string[] $queryParameters
     * @param string[] $postBody
     */
    public function __construct(string $method, string $path, array $queryParameters, array $postBody)
    {
        $this->method = $method;
        $this->path = $path;
        $this->queryParameters = $queryParameters;
        $this->postBody = $postBody;
    }
}
