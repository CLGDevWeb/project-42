<?php

namespace App\Controllers;

use App\Widget;
use Framework\Http\Response;

class HomeController
{
    public function __construct(private Widget $widget)
    {}
    
    public function index(): Response
    {
        return new Response("Index {$this->widget->name}");
    }
}