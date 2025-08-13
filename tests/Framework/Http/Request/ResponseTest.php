<?php

namespace Framework\Http\Request;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ResponseTest extends TestCase
{
    public function testCreateResponse(): void
    {
        $resource = new Stream(fopen('php://memory', 'rb+'));
        $resource->write('Test');
        $response = new Response($resource, 200, ['Content-Type' => 'text/html']);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Test', $response->getContent());
        self::assertEquals('text/html', $response->getHeader('Content-Type'));
        self::assertEquals('default', $response->getHeader('Test', 'default'));
        self::assertEquals(['Content-Type' => 'text/html'], $response->getHeaders());
    }

    public function testHeader(): void
    {
        $resource = new Stream(fopen('php://memory', 'rb+'));
        $resource->write('Test');
        $response = new Response($resource, 200);

        $response2 = $response
            ->withHeader('Content-type', 'text/html')
            ->withHeader('X-Frame-Options', 'DENY')
            ->withAddedHeader('Content-type', 'charset=utf-8');

        $response = $response
            ->withHeader('Content-type', 'text/html')
            ->withHeader('X-Frame-Options', 'DENY');

        self::assertEquals(['text/html'], $response->getHeader('Content-type'));
        self::assertEquals(['DENY'], $response->getHeader('X-Frame-Options'));
        self::assertEquals([
            'Content-type' => ['text/html'],
            'X-Frame-Options' => ['DENY'],
        ], $response->getHeaders());

        self::assertEquals([
            'Content-type' => ['text/html', 'charset=utf-8'],
            'X-Frame-Options' => ['DENY'],
        ], $response2->getHeaders());
    }
}
