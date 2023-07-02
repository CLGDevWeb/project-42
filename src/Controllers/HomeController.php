<?php

namespace App\Controllers;

use App\Widget;
use Framework\Http\Response;

class HomeController
{
    public function __construct(private Widget $widget, private \Twig\Environment $twig)
    {}
    
    public function index(): Response
    {
        dd($this->twig);
        
        return new Response("Index {$this->widget->name}");
    }
}