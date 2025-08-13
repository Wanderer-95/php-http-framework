<?php

declare(strict_types=1);

namespace Framework\Http\Request;

final class ServerRequest
{
    private array $serverParams;
    private string $method;
    private Uri $uri;
    private array $queryParams;
    private array $cookieParams;
    private Stream $body;
    private array $headers;
    private ?array $parsedBody;

    public function __construct(
        array $serverParams,
        string $method,
        Uri $uri,
        array $queryParams,
        array $cookieParams,
        Stream $body,
        array $headers,
        ?array $parsedBody
    ) {
        $this->serverParams = $serverParams;
        $this->method = $method;
        $this->uri = $uri;
        $this->queryParams = $queryParams;
        $this->cookieParams = $cookieParams;
        $this->body = $body;
        $this->headers = $headers;
        $this->parsedBody = $parsedBody;
    }

    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCookieParams(): array
    {
        return $this->cookieParams;
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }

    public function withParsedBody(?array $body): self
    {
        $clone = clone $this;
        $clone->parsedBody = $body;
        return $clone;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getHeader(string $key): string
    {
        /** @var string|list<string> $value */
        $value = $this->headers[$key] ?? '';

        if (is_array($value)) {
            /** @var list<string> $value */
            return implode(', ', $value);
        }

        return $value;
    }

    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBody(): Stream
    {
        return $this->body;
    }
}
