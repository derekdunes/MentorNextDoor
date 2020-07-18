<?php

namespace App\Providers;

use \App\Billing\Stripe;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('layouts.aside', function ($view) {
            
            $view->with('archives', \App\Post::archives());

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {    
        Schema::defaultStringLength(191);
        $this->app->singleton(Stripe::class, function () {
            return new Stripe(config('services.stripe.secret'));
        });
    }
}
