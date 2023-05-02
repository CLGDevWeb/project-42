<?php 

declare(strict_types=1);

namespace Framework\Http;

use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        // Create a dispatcher
        $dispatcher = simpleDispatcher(function(\FastRoute\RouteCollector $routeCollector) {
            $routeCollector->addRoute('GET', '/', function() {
                $content = "<h1>Test framework !</h1>";

                return new Response($content);
            });

            $routeCollector->addRoute('GET', '/posts/{id:\d+}', function($routeParams) {
                $content = "<h1>Post {$routeParams['id']}</h1>";

                return new Response($content);
            });
        });

        // Dispatch a URI, to obtain route info
        $routeInfo = $dispatcher->dispatch($request->server['REQUEST_METHOD'], $request->server['REQUEST_URI']);
        [$status, $handler, $vars] = $routeInfo;

        // Call the handler, provided by the route info, in order to create a Response
        return $handler($vars);
    }
}