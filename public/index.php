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

    if (!is_string($name)) {
        return new Response(new Stream(fopen('php://memory', 'rb')), 400, []);
    }

    $lang = detectLang($request, 'en');

    $content = 'Hello, ' . $name . '| Lang - ' . $lang . '!';

    $response = new Response()
        ->withHeader('Content-Type', 'text/html');
    $response->getContent()->write($content);
    return $response;
}

$request = createServerRequestFromGlobals();

if (str_starts_with($request->getHeader('Content-Type'), 'application/x-www-form-urlencoded')) {
    parse_str($request->getBody()->getContents(), $data);
    $request = $request->withParsedBody($data);
}

$response = home($request);

$response = $response
    ->withHeader('X-Frame-Options', 'DENY');

emitResponseToSapi($response);


class User
{
    private string $name = 'Alex';

    private function sayHello(): string
    {
        return 'Hello, wewqeqeqorld!';
    }
}

$surname = 'Petrovich32132131';

$getName = function (): string {
    return $this->sayHello();
};
$user = new User();
$bound = $getName->bindTo($user, User::class);

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo $bound();