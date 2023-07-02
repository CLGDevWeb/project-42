<?php 

declare(strict_types=1);

namespace Framework\Http\Routing;

use FastRoute\Dispatcher;
use Framework\Http\Exception\HttpException;
use Framework\Http\Exception\HttpRequestMethodException;
use Framework\Http\Request;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;
    
    public function dispatch(Request $request, ContainerInterface $container): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;

            $controller = $container->get($controllerId);

            $handler = [$controller, $method];
        }

        return [$handler, $vars];
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(\FastRoute\RouteCollector $routeCollector) {
            foreach($this->routes as $route) {
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