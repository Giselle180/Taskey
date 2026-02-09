<?php

// To start the page
require __DIR__ . '/../vendor/autoload.php';

// Debug info
// phpinfo();

// Import
use App\views\RouteProvider;
use App\views\ServiceProvider;
use Framework\Kernel;
use Framework\Request;

// Create kernel
$kernel = new Kernel();

// Gets the router
$routeProvider = new RouteProvider();
// Defines routes
$kernel->registerRoutes($routeProvider);

//Define services
$kernel->registerServices(new ServiceProvider());

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
