<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {$this->routes['GET'][$path] =$handler;
    }

    public function post(string $path, array $handler): void {$this->routes['POST'][$path] =$handler;
    }

    public function dispatch(string $method, string$uri): void {
        $uri = rtrim($uri, '/') ?: '/';
        foreach ($this->routes[$method] ?? [] as$route => $handler) {$pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([0-9]+)', $route);$pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri,$matches)) {
                array_shift($matches);
                [$controllerClass, $action] =$handler;
                $controller = new$controllerClass();
                call_user_func_array([$controller, $action], array_map('intval',$matches));
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1><a href='/'>Voltar ao início</a>";
    }
}