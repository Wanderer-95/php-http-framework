<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use function Framework\Http\createServerRequestFromGlobals;

use Framework\Http\Request\Response;
use Framework\Http\Request\ServerRequest;
use Framework\Http\Request\Stream;

http_response_code(500);

function home(ServerRequest $request): Response
{
    $name = $_GET['name'] ?? 'Guest';

    if (! is_string($name)) {
        return new Response(new Stream(fopen('php://memory', 'rb')), 400, []);
    }

    $lang = detectLang($request, 'en');

    $content = 'Hello, ' . $name . '| Lang - ' . $lang . '!';
    $stream = new Stream(fopen('php://memory', 'rb+'));
    $stream->write($content);

    return new Response(
        $stream,
        200
    );
}

$request = createServerRequestFromGlobals();

$response = home($request);

$response = $response
    ->withHeader('Content-type', 'text/html; charset=utf-8')
    ->withHeader('X-Frame-Options', 'DENY');

emitResponseToSapi($response);
