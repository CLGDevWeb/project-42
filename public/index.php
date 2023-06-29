<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use Framework\Http\Request;
use Framework\Http\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

dd($container);

$request = Request::createFromGlobals();

$response = (new Kernel(new Router()))->handle($request);

$response->send();
