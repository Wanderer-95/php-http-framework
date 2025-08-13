<?php

namespace Framework\Http\Request;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UriTest extends TestCase
{
    public function testCreateUri(): void
    {
        $uri = new Uri($string = 'http://user:pass@hostname:9090/path?param=value#hash');

        self::assertEquals('http', $uri->getScheme());
        self::assertEquals('user:pass', $uri->getUserInfo());
        self::assertEquals('hostname', $uri->getHost());
        self::assertEquals('9090', $uri->getPort());
        self::assertEquals('/path', $uri->getPath());
        self::assertEquals('param=value', $uri->getQuery());
        self::assertEquals('user', $uri->getUser());
        self::assertEquals('pass', $uri->getPass());
        self::assertEquals('hash', $uri->getFragment());

        self::assertEquals($string, (string)$uri);
    }
}
