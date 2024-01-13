<?php
include 'php/controller/homeController.php';

class Router {
    private $routes = [];

    public function addRoute($path, $controller, $method) {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch() {
       //get in $_GET['path'] if exists
        $requestedPath = isset($_GET['path']) ? $_GET['path'] : '/';

        if (array_key_exists($requestedPath, $this->routes)) {
            $route = $this->routes[$requestedPath];
            $controller = new $route['controller']();
            call_user_func([$controller, $route['method']]);
        } else {
            $this->notFound();
        }
    }

    public function notFound() {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit();
    }
}
?>