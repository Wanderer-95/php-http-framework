<?php

namespace Framework\Http\Request;

use RuntimeException;

final class Stream
{
    /**
     * @var false|resource|string $resource
     */
    private mixed $resource;

    /**
     * @param false|resource|string $resource
     */
    public function __construct(
        mixed $resource,
    ) {
        $this->resource = $resource;
    }

    public function seek(int $offset): void
    {
        if (! is_resource($this->resource)) {
            throw new RuntimeException('Invalid stream resource');
        }

        fseek($this->resource, $offset);
    }

    public function rewind(): void
    {
        $this->seek(0);
    }

    public function read(int $length): string
    {
        if (! is_resource($this->resource)) {
            throw new RuntimeException('Invalid stream resource');
        }
        $data = fread($this->resource, $length);
        return $data === false ? '' : $data;
    }

    public function write(string $content): void
    {
        if (! is_resource($this->resource)) {
            throw new RuntimeException('Invalid stream resource');
        }

        fwrite($this->resource, $content);
    }

    public function getContents(): string
    {
        if (! is_resource($this->resource)) {
            throw new RuntimeException('Invalid stream resource');
        }

        $contents = stream_get_contents($this->resource);
        return $contents === false ? '' : $contents;
    }

    public function __toString(): string
    {
        $this->rewind();
        return $this->getContents();
    }
}
