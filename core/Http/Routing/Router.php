<?php 

declare(strict_types=1);

namespace Framework\Http\Routing;

use FastRoute\Dispatcher;
use Framework\Http\Exception\HttpException;
use Framework\Http\Exception\HttpRequestMethodException;
use Framework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $method] = $handler;

            $handler = [new $controller, $method];
        }

        return [$handler, $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(\FastRoute\RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            httpMethod: $request->getMethod(), 
            uri: $request->getPathInfo()
        );

        return match($routeInfo[0]) {
            Dispatcher::FOUND => [$routeInfo[1], $routeInfo[2]],
            Dispatcher::METHOD_NOT_ALLOWED => throw new HttpRequestMethodException("The allowed methods are : " . implode(', ', $routeInfo[1]), 405),
            default => throw new HttpException('Not found', 404)
        };
    }
}