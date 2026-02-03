<?php

require __DIR__ . '/../vendor/autoload.php';

// Debug info
// phpinfo();

// Import
use Framework\Kernel;
use Framwork\Request;
use Framework\Respose;

// create kernel
$kernel = new Kernel();

// Extracts path from the uri
$urlPath = parse_url($_SERVER['REQUEST_URI']);
if (!is_string($urlPath)) {
    $urlPath = "/";
}

// create request
$request = new Request($_SERVER['REQUEST_METHOD'], $urlPath, $_GET, $_POST);

// Passing the response to the kernel
$response = $kernel->handle($request);

$response->echo();