<?php

namespace Framework\Http;

use Framework\Http\Request\ServerRequest;
use Framework\Http\Request\Stream;
use Framework\Http\Request\Uri;

/**
 * @param array<string, string>|null $server
 * @param array<string, array|string>|null $query
 * @param array<string, string>|null $cookie
 * @param array<string, array|string>|null $body
 * @param false|string|null $input
 */
function createServerRequestFromGlobals(
    ?array $server = null,
    ?array $query = null,
    ?array $cookie = null,
    ?array $body = null,
    string|null|bool $input = null,
): ServerRequest {

    $server ??= $_SERVER;

    $headers = [
        'Content-Type' => $server['CONTENT_TYPE'],
        'Content-Length' => $server['CONTENT_LENGTH'],
    ];

    foreach ($server as $name => $value) {
        if (str_starts_with($name, 'HTTP_')) {
            $name = ucwords(strtolower(str_replace('_', '-', substr($name, 5))), '-');
            $headers[$name] = $value;
        }
    }

    return new ServerRequest(
        serverParams: $server,
        method: $server['REQUEST_METHOD'],
        uri: new Uri(
            (($server['REQUEST_SCHEME'] !== '' ? 'https' : 'http') . '://' . $server['HTTP_HOST'] . ($server['SERVER_PORT'] !== '' ? ':40' : '') . $server['REQUEST_URI'])
        ),
        queryParams: $query ?? $_GET,
        cookieParams: $cookie ?? $_COOKIE,
        body: new Stream($input ?? fopen('php://input', 'rb')),
        headers: $headers,
        parsedBody: $body ?? ($_POST ?: null),
    );
}
