<?php namespace Tamkeen\Ajeer\Services\OpenId;

use Illuminate\Http\Request;

interface OpenIdService
{
    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws OpenIdAuthenticationFailedException
     */
    public function authenticate(Request $request);

    /**
     * @return string
     */
    public function getAuthenticationEndpoint();
}
