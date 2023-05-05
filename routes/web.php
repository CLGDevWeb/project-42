<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Framework\Http\Response;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostController::class, 'show']],
    ['GET', '/test/{name:.+}', function(string $name) {
        return new Response("Hello {$name}");
    }],
];