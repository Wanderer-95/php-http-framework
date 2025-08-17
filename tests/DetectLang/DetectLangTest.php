<?php

namespace DetectLang;

use Framework\Http\Request\ServerRequest;
use Framework\Http\Request\Stream;
use Framework\Http\Request\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class DetectLangTest extends TestCase
{
    public function testDefault(): void
    {
        $request = new ServerRequest(
            serverParams: [],
            method: 'GET',
            uri: new Uri('/'),
            queryParams: [],
            cookieParams: [],
            body: new Stream(fopen('php://memory', 'rb')),
            headers: [],
            parsedBody: null
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('en', $lang);
    }

    public function testQueryParam(): void
    {
        $request = new ServerRequest(
            serverParams: [],
            method: 'GET',
            uri: new Uri('/'),
            queryParams: ['lang' => 'de'],
            cookieParams: ['lang' => 'pt'],
            body: new Stream(fopen('php://memory', 'rb')),
            headers: ['Accept-Language' => 'ru-ru'],
            parsedBody: null
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('de', $lang);
    }

    public function testCookieParam(): void
    {
        $request = new ServerRequest(
            serverParams: [],
            method: 'GET',
            uri: new Uri('/'),
            queryParams: [],
            cookieParams: ['lang' => 'pt'],
            body: new Stream(fopen('php://memory', 'rb')),
            headers: ['Accept-Language' => 'ru-ru'],
            parsedBody: null
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('pt', $lang);
    }

    public function testHeaderParam(): void
    {
        $request = new ServerRequest(
            serverParams: [],
            method: 'GET',
            uri: new Uri('/'),
            queryParams: [],
            cookieParams: [],
            body: new Stream(fopen('php://memory', 'rb')),
            headers: ['Accept-Language' => 'ru-ru'],
            parsedBody: null
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('ru', $lang);
    }
}
