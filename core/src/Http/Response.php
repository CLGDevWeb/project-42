<?php

declare(strict_types=1);

namespace Framework\Http;

class Response
{
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    
    public function __construct(
        public readonly ?string $content = '',
        public readonly int $status = 200,
        public readonly array $headers = [],
    ) 
    {
        http_response_code($this->status);
    }

    public function send(): void
    {
        echo $this->content;
    }
}