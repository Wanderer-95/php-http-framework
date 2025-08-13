<?php

namespace Framework\Http;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CreateServerRequestFromGlobalsTest extends TestCase
{
    public function testGlobals(): void
    {
        $serverParams = [
            'SERVER_PORT' => '40',
            'HTTP_HOST' => 'localhost',
            'REQUEST_SCHEME' => 'http',
            'HTTP_ACCEPT_LANGUAGE' => 'en',
            'CONTENT_TYPE' => 'text/plain',
            'CONTENT_LENGTH' => '4',
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET',
        ];
        $queryParams = ['foo' => 'bar', 'baz' => 'qux'];
        $cookieParams = ['cookie1' => 'value1', 'cookie2' => 'value2'];
        $body = ['title' => 'post'];

        $request = createServerRequestFromGlobals($serverParams, $queryParams, $cookieParams, $body);
        self::assertEquals($serverParams, $request->getServerParams());
        self::assertEquals($queryParams, $request->getQueryParams());
        self::assertEquals($cookieParams, $request->getCookieParams());
        self::assertEquals($body, $request->getParsedBody());
        self::assertEquals($serverParams['REQUEST_METHOD'], $request->getMethod());
        self::assertEquals($serverParams['REQUEST_URI'], $request->getUri()->getPath());
        self::assertEquals([
            'Content-Type' => 'text/plain',
            'Host' => 'localhost',
            'Content-Length' => '4',
            'Accept-Language' => 'en',
        ], $request->getHeaders());
        self::assertEquals('', $request->getBody()->getContents());
    }
}
