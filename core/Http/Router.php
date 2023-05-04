<?php 

declare(strict_types=1);

namespace Framework\Http;

use Framework\Contracts\RouterInterface;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        
        $dispatcher = simpleDispatcher(function(\FastRoute\RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(), 
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        return [
            [new $controller, $method], 
            $vars
        ];
    }
}