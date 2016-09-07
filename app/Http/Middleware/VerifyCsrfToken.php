<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

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
}
