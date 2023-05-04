<?php

namespace Framework\Contracts;

use Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}