<?php 

declare(strict_types=1);

namespace Framework\Http;

use Framework\Http\Exception\HttpException;
use Framework\Http\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class Kernel
{
    private string $appEnv;
    
    public function __construct(private RouterInterface $router, private ContainerInterface $container)
    {
        $this->appEnv = $this->container->get('APP_ENV');
    }
    
    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            return call_user_func_array($routeHandler, $vars);
        } catch(\Exception $exception) {
            return $this->createExceptionResponse($exception);
        }
    }

    /**
     * @throws \Exception $exception
     */
    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array($this->appEnv, ['dev', 'test'])) {
            throw $exception;
        }
        
        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getCode());
        }

        return new Response('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}