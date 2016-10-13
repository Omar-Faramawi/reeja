<?php namespace Tamkeen\Ajeer\Services\OpenId;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Tamkeen\Ajeer\Models\User;

class OpenIdDummyService implements OpenIdService
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        $userData = [
            'name'           => 'مستخدم تجريبي #1',
            'id_number'      => 1010101010,
            'email'          => "email@provider.tld",
            'mobile'         => 966555110823,
            'establishments' => [
                '1-1' => 'منشأة تجريبية #1',
                '1-2' => 'منشأة تجريبية #2',
                '1-3' => 'منشأة تجريبية #3',
                '1-4' => 'منشأة تجريبية #4',
                '1-5' => 'منشأة تجريبية #5',
            ],
        ];

        return $userData;
    }

    /**
     * @return string
     */
    public function getAuthenticationEndpoint()
    {
        return '';
    }
}
