<?php

namespace Tamkeen\Ajeer\Providers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Tamkeen\Ajeer\Models\Contract;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('contract_field_cannot_edit_if_approved',
            function ($attribute, $value, $parameters) {
                $id = $parameters[0];
                try {
                    $status = Contract::findOrFail($id)->status;
                    
                    return $status !== "approved";
                    
                } catch (ModelNotFoundException $e) {
                    return trans('labels.not_found');
                }
            }
        );
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
