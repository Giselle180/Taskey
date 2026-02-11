<?php

namespace Framework;

class ResponseFactory
{
    public function body(string $text): Response
    {
        $response = new Response($text, 200);
        return $response;
    }

    public function notFound(): Response
    {
        $newText = "Page not Found";
        $response = new Response($newText, 404);
        return $response;
    }
}
