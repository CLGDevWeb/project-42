<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostController::class, 'show']],
];