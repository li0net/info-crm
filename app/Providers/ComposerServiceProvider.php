<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Request;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        /*
        View::composer(
            'profile', 'App\Http\ViewComposers\ProfileComposer'
        );
        */

        // Closure based composer
        View::composer('adminlte::layouts.partials.sidebar', function ($view) {
            $view->with('crmuser', Request::user());
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}