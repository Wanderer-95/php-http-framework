<?php

namespace Framework\Http\Request;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class StreamTest extends TestCase
{
    public function testEmpty(): void
    {
        $resource = fopen('php://memory', 'rb');
        $stream = new Stream($resource);
        self::assertEquals('', $stream->getContents());
    }

    public function testOver(): void
    {
        $resource = fopen('php://memory', 'rb');
        self::assertIsResource($resource);
        fwrite($resource, 'foo');
        $stream = new Stream($resource);
        self::assertEquals('', $stream->getContents());
    }

    public function testRewind(): void
    {
        $resource = fopen('php://memory', 'rb+');
        self::assertIsResource($resource);
        fwrite($resource, 'foo');
        $stream = new Stream($resource);
        $stream->rewind();
        self::assertEquals('foo', $stream->getContents());
    }

    public function testSeekRead(): void
    {
        $resource = fopen('php://memory', 'rb+');
        self::assertIsResource($resource);
        fwrite($resource, 'foo bar');
        $stream = new Stream($resource);
        $stream->seek(2);
        self::assertEquals('o b', $stream->read(3));
    }

    public function testToString(): void
    {
        $resource = fopen('php://memory', 'rb+');
        self::assertIsResource($resource);
        fwrite($resource, 'Body');
        $stream = new Stream($resource);
        self::assertEquals('Body', (string)$stream);
    }
}
