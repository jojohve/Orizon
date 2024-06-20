<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once 'router.php';
require_once 'config/db_connection.php';
require_once 'controllers/CountryController.php';
require_once 'controllers/TripController.php';
$routes = require_once 'routes.php';

$router = new Router($routes);

$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
