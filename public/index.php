<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$response = (new Kernel())->handle($request);

$response->send();
