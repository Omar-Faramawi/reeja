<?php

namespace Tamkeen\Ajeer\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Tamkeen\Ajeer\Http\Middleware\Locale::class,
        \Tamkeen\Ajeer\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Tamkeen\Ajeer\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
//            \Tamkeen\Ajeer\Http\Middleware\EncryptCookies::class,
//            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//            \Illuminate\Session\Middleware\StartSession::class,
//            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \Tamkeen\Ajeer\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                         => \Tamkeen\Ajeer\Http\Middleware\Authenticate::class,
        'auth.basic'                   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can'                          => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest'                        => \Tamkeen\Ajeer\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'                     => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'admin_auth'                   => \Tamkeen\Ajeer\Http\Middleware\AdminAuth::class,
        'contractCancelation'          => \Tamkeen\Ajeer\Http\Middleware\contractCancelation::class,
        'laborer'                      => \Tamkeen\Ajeer\Http\Middleware\Laborer::class,
        'individual'                   => \Tamkeen\Ajeer\Http\Middleware\Individual::class,
        'establishment'                => \Tamkeen\Ajeer\Http\Middleware\Establishment::class,
        'hajj_government'              => \Tamkeen\Ajeer\Http\Middleware\HajjGovernment::class,
        'shwagher_auth'                => \Tamkeen\Ajeer\Http\Middleware\ShwagherAuth::class,
        'indvidualContractCancelation' => \Tamkeen\Ajeer\Http\Middleware\IndvidualContractCancelation::class,
        'establishment' => \Tamkeen\Ajeer\Http\Middleware\Establishment::class,
    ];
}
