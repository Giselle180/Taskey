<?php

namespace Framework;

class Kernel
{
    public function __construct()
    {
        // nothing yet
    }

    // You don't have to import bc they're in the same name space
    public function handle(Request $request): Response
    {
        // Print message taken from method on request
        $message = "Thank you for your request" . $request->path;
        $response = new Response($message);
        return $response;
    }
}
