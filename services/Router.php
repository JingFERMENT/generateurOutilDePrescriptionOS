<?php

class Router {
    private $routes = [];

    /**
     * Add a route to the router.
     *
     * @param string $path The URI path (e.g., '/listCampagne').
     * @param string $controller The file to include for this route.
     */
    public function addRoute(string $path, string $controller) {
        $this->routes[$path] = $controller;
    }

    /**
     * Match the current URI against defined routes and include the corresponding controller.
     *
     * @param string $uri The current URI (e.g., '/listCampagne').
     */
    public function dispatch(string $uri) {
        if (array_key_exists($uri, $this->routes)) {
            include $this->routes[$uri];
        } else {
            $this->handleNotFound();
        }
    }

    /**
     * Handle unmatched routes (404).
     */
    private function handleNotFound() {
        include 'views/templates/404.php';
    }
}
