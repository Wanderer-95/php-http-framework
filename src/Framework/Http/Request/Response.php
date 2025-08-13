<?php

namespace Framework\Http\Request;

final class Response
{
    private Stream $content;
    private int $statusCode;

    /** @var array<string, list<string>|string> */
    private array $headers;

    /**
     * @param array<string, list<string>|string> $headers
     */
    public function __construct(?Stream $content = null, int $statusCode = 200, array $headers = [])
    {
        $this->headers = $headers;

        $this->content = $content ?? new Stream(fopen('php://memory', 'rb+'));
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, list<string>|string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return list<string>|string
     */
    public function getHeader(string $name, string $default = ''): string|array
    {
        return $this->headers[$name] ?? $default;
    }

    /**
     * @return static
     */
    public function withAddedHeader(string $name, string $value): self
    {
        $clone = clone $this;
        if (!isset($clone->headers[$name])) {
            $clone->headers[$name] = [];
        }
        $clone->headers[$name][] = $value;
        return $clone;
    }

    /**
     * @return static
     */
    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = [$value];
        return $clone;
    }

    public function getContent(): Stream
    {
        return $this->content;
    }
}
