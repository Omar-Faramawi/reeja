<?php

namespace Tamkeen\Ajeer\Providers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Validators\SaudiPercentageValidator;

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
        
        $this->registerCustomValidation($this->app['validator']);
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

    private function registerCustomValidation(Factory $validator)
    {
        $validator->extend('saudi_percentage_unique', 'Tamkeen\Ajeer\Validators\SaudiPercentageValidator@validateSaudiPercentageUnique');
        $validator->extend('greater_than', 'Tamkeen\Ajeer\Validators\GreaterThanValidator@validateGreaterThan');
        $validator->extend('phone_number', 'Tamkeen\Ajeer\Validators\PhoneNumberValidator@validatePhoneNumber');
    }
}
