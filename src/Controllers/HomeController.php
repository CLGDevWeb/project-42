<?php

namespace App\Controllers;

use Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response('Index');
    }
}