<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use Framework\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$response = (new Kernel())->handle($request);

$response->send();
