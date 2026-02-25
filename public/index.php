<?php

// To start the page
require __DIR__ . '/../vendor/autoload.php';

// Debug info
// phpinfo();

// Import
use App\RouteProvider;
use App\ServiceProvider;
use Framework\Kernel;
use Framework\Request;

$config = [
    'APP_ENV' => 'development',
    'VIEWS_PATH' => 'app/views',
];

// Create kernel
$kernel = new Kernel($config);

//Define services
$kernel->registerServices(new ServiceProvider());

// Defines routes
$kernel->registerRoutes(new RouteProvider());

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Extracts path from the uri
// Specific code input
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!is_string($urlPath)) {
    $urlPath = "/";
}

// Get query (GET) parameters
$queryParams = $_GET;

// Get POST data
$postData = $_POST;

// Create request
// Specific code input
$request = new Request($method, $urlPath, $queryParams, $postData);

// Passing the response to the kernel handler container
$response = $kernel->handle($request);

// Prints message
$response->echo();
