<?php

use Framework\Http\Request\ServerRequest;

function detectLang(ServerRequest $request, string $default): string
{
    if (isset($request->getQueryParams()['lang']) && is_string($request->getQueryParams()['lang']) && $request->getQueryParams()['lang'] !== '') {
        return $request->getQueryParams()['lang'];
    }

    if (isset($request->getCookieParams()['lang']) && is_string($request->getCookieParams()['lang']) && $request->getCookieParams()['lang'] !== '') {
        return $request->getCookieParams()['lang'];
    }

    if (isset($request->getHeaders()['Accept-Language']) && is_string($request->getHeaders()['Accept-Language']) && $request->getHeaders()['Accept-Language'] !== '') {
        return substr($request->getHeaders()['Accept-Language'], 0, 2);
    }

    return $default;
}
