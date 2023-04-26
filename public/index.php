<?php

use Framework\Http\Request;
use Framework\Http\Response;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$content = "<h1>Test framework !</h1>";

$response = new Response(content: $content, status: 404, headers: []);

$response->send();