<?php

namespace App\Controllers;

use Framework\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        return new Response('Show ' . $id);
    }
}