<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use Framework\Http\Request;
use Framework\Http\Router;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$response = (new Kernel(new Router()))->handle($request);

$response->send();
