<?php

namespace Webkul\Checkout\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Webkul\Checkout\Facades\Cart;

class CheckoutServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->register(ModuleServiceProvider::class);

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerFacades();
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades(): void
    {
        //to make the cart facade and bind the
        //alias to the class needed to be called.
        $loader = AliasLoader::getInstance();

        $loader->alias('cart', Cart::class);

        $this->app->singleton('cart', function () {
            return new cart();
        });

        $this->app->bind('cart', 'Webkul\Checkout\Cart');
    }
}