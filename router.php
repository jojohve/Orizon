<?php

class Router
{
    private $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function handleRequest($uri, $method)
    {
        $uri = rtrim($uri, '/');
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9_\-]+)', $route['route']);
            if ($route['method'] === $method && preg_match("#^$pattern$#", $uri, $matches)) {
                $controllerName = $route['controller'];
                $action = $route['action'];

                $controller = new $controllerName();
                $params = array_slice($matches, 1);

                call_user_func_array([$controller, $action], $params);

                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}
