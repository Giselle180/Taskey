<?php

require __DIR__ . '/../vendor/autoload.php';

// Debug info
// phpinfo();

// Import
use Framework\Kernel;
use Framework\Request;
use Framework\Respose;

// Create kernel
$kernel = new Kernel();

// Extracts path from the uri
// Specific code input
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!is_string($urlPath)) {
    $urlPath = "/";
}

// Create request
// Specific code input
$request = new Request($_SERVER['REQUEST_METHOD'], $urlPath, $_GET, $_POST);

// Passing the response to the kernel handler container
$response = $kernel->handle($request);

// Prints message
$response->echo();
