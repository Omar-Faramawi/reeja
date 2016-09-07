<?php

namespace Tamkeen\Ajeer\Providers;

use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;
use Tamkeen\Ajeer\Repositories\MOL\MolDataDummyRepository;
use Tamkeen\Ajeer\Repositories\MOL\MolDataMssqlRepository;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;
use Tamkeen\Ajeer\Services\MOL\MolDummyServices;
use Tamkeen\Ajeer\Services\MOL\MolServices;
use Tamkeen\Ajeer\Services\MOL\MolSoapServices;
use Tamkeen\Ajeer\Services\OpenId\OpenIdDummyService;
use Tamkeen\Ajeer\Services\OpenId\OpenIdMolService;
use Tamkeen\Ajeer\Services\OpenId\OpenIdService;
use Tamkeen\Platform\Billing\Connectors\Connector;
use Tamkeen\Platform\Billing\Connectors\HttpApiConnector;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Guard $auth
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        view()->composer('admin.layout', function ($view) use ($auth) {
            $view->with('auth_user', $auth->user());
        });

        view()->composer('front.layout', function ($view) use ($auth) {
            $view->with('auth_user', $auth->user());
        });

        view()->composer('*', function ($view) {
            if ( ! is_null(request()->route())) {
                $currentRouteName = \Request::route()->getName();
                $view->with('current_route_name', $currentRouteName);
            }
        });

        Carbon::setLocale(config('app.locale'));
 
        Blade::extend(function($value) {
            return preg_replace('/(\s*)@break(\s*)/', '$1<?php break; ?>$2',
                $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBillingSystem();

        if (env('APP_ENV') == 'local') {
            $this->registerDummyServices();
            $this->registerDummyRepositories();
        } else {
            $this->registerLiveServices();
            $this->registerLiveRepositories();
        }
    }

    /**
     * Register Billing System
     *
     * @return void
     */
    private function registerBillingSystem()
    {
        $this->app->bind(Connector::class, function ($app) {
            return new HttpApiConnector(config('billing.config'), config('billing.debug'), $app['log']);
        });
    }

    /**
     * ٍRegister Dummy Services
     *
     * @return void
     */
    private function registerDummyServices()
    {
        $this->app->bind(OpenIdService::class, function ($app) {
            return new OpenIdDummyService;
        });

        $this->app->bind(MolServices::class, function ($app) {
            return new MolDummyServices($app[MolDataRepository::class]);
        });
    }

    /**
     * ٍRegister Dummy Repositories
     *
     * @return void
     */
    private function registerDummyRepositories()
    {
        $this->app->bind(MolDataRepository::class, function ($app) {
            return new MolDataDummyRepository;
        });
    }

    /**
     * Register Live Services
     *
     * @return void
     */
    private function registerLiveServices()
    {
        $this->app->bind(OpenIdService::class, function ($app) {
            return new OpenIdMolService(
                $app[MolDataRepository::class],
                config('openid.provider'),
                route(config('openid.return_to'))
            );
        });

        $this->app->bind(MolServices::class, function ($app) {
            return new MolSoapServices;
        });
    }

    /**
     * Register Live Repositories
     *
     * @return void
     */
    private function registerLiveRepositories()
    {
        $this->app->bind(MolDataRepository::class, function ($app) {
            return new MolDataMssqlRepository($app['db']->connection('mol'), $app['cache.store']);
        });
    }

}
