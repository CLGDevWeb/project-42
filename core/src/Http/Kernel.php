<?php 

declare(strict_types=1);

namespace Framework\Http;

use Framework\Http\Exception\HttpException;
use Framework\Http\Routing\Router;

class Kernel
{
    public function __construct(private Router $router)
    {}
    
    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);

            return call_user_func_array($routeHandler, $vars);
        } catch(HttpException $e) {
            return new Response($e->getMessage(), $e->getCode());
        } catch(\Exception $e) {
            return new Response($e->getMessage(), 500); //fix status
        }
    }
}