<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Symfony\Component\HttpFoundation\Cookie;
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/Billing/api/1.0/get-account',
        '/Billing/api/1.0/create-bill',
        '/api/2.0/notify-payment',
    ];

    /**
    * Add the CSRF token to the response cookies.
    * Add Httponly, secure flag to xsrf cookie
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Illuminate\Http\Response $response
    * @return \Illuminate\Http\Response
    */
    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120, '/', null, false, true));

        return $response;
    }
}
