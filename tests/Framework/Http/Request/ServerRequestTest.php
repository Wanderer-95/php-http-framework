<?php

namespace Framework\Http\Request;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ServerRequestTest extends TestCase
{
    public function testCreateServerRequest(): void
    {
        $request = new ServerRequest(
            serverParams: $serverParams = ['HOST' => 'localhost'],
            method: $method = 'GET',
            uri: $uri = new Uri('http://username:password@hostname:9090/path?arg=value#anchor'),
            queryParams: $queryParams = ['name' => 'John Doe'],
            cookieParams: $cookieParams = ['Cookie' => 'Val'],
            body: $body = new Stream(fopen('php://memory', 'rb')),
            headers: $headers = [
                'Accept-Language' => 'en',
            ],
            parsedBody: $parsedBody = ['title' => 'Post 1'],
        );

        self::assertEquals($serverParams, $request->getServerParams());
        self::assertEquals($method, $request->getMethod());
        self::assertEquals($uri, $request->getUri());
        self::assertEquals($queryParams, $request->getQueryParams());
        self::assertEquals($cookieParams, $request->getCookieParams());
        self::assertEquals($body, $request->getBody());
        self::assertEquals($headers, $request->getHeaders());
        self::assertEquals($parsedBody, $request->getParsedBody());
        self::assertEquals('username', $request->getUri()->getUser());
        self::assertEquals('password', $request->getUri()->getPass());
        self::assertEquals('http', $request->getUri()->getScheme());
    }
}
