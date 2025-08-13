<?php

namespace Framework\Http\Request;

final class Response
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(private Stream $content, private int $statusCode = 200, private array $headers = [])
    {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name, string $default = ''): string
    {
        return $this->headers[$name] ?? $default;
    }

    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;
        return $clone;
    }

    public function getContent(): Stream
    {
        return $this->content;
    }
}
