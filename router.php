<?php

class Router {
    private $routes = [];

    public function __construct() {
        $this->routes = require 'routes.php';
    }

    public function handleRequest($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['route'] === $uri && $route['method'] === $method) {
                call_user_func([new $route['controller'], $route['action']]);
                return;
            }
        }
        http_response_code(404);
        echo "Route not found.";
    }
}
