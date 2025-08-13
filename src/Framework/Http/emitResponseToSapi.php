<?php

use Framework\Http\Request\Response;

function emitResponseToSapi(Response $response): void
{
    http_response_code($response->getStatusCode());

    /**
     * @var string $name
     * @var string $value
     */
    foreach ($response->getHeaders() as $name => $value) {
        header($name . ': ' . $value);
    }

    $stream = $response->getContent();
    $stream->rewind();

    do {
        $content = $stream->read(1024 * 8);
        echo $content;
    } while ($content !== '');
}
