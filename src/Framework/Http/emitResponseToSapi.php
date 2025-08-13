<?php

use Framework\Http\Request\Response;

function emitResponseToSapi(Response $response): void
{
    http_response_code($response->getStatusCode());

    foreach ($response->getHeaders() as $name => $values) {
        // Если строка, оборачиваем в массив для foreach
        if (is_string($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            header($name . ': ' . $value, false);
        }
    }

    $stream = $response->getContent();
    $stream->rewind();

    do {
        $content = $stream->read(1024 * 8);
        echo $content;
    } while ($content !== '');
}
