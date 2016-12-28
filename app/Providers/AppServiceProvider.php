<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // custom validation rule for phone numbers
        Validator::extend('phone_crm', function ($attribute, $value, $parameters, $validator) {
            //' +7 (927) 342-23 45 '
            return preg_match('/^([0-9\+\(\)\s-]+)$/', $value, $matches);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
