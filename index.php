<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'routes.php';

$router = new Router();

$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
