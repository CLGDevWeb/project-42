<?php

use Framework\Http\Kernel;
use Framework\Http\Routing\Router;
use Framework\Http\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new \League\Container\Container();

$container->delegate(new ReflectionContainer(true));

# parameters for app config
$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$viewsPath = BASE_PATH . '/views';

$container->add('APP_ENV', new StringArgument($appEnv));

# services
$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
    ->addMethodCall('setRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->addShared('filesystem-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new StringArgument($viewsPath));

$container->addShared(\Twig\Environment::class)
    ->addArgument('filesystem-loader');

return $container;