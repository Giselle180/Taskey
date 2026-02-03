<?php

// This is the namespace
namespace Framework;

class Kernel
{
    public function __construct()
    {

    }

    // You don't have to import bc they're in the same name space
    public function handle(Request $request): Response
    {
        $message = "Thank you for your request". $request->getMethod();
        $response = new Response($message);
        return $response;
    }
}