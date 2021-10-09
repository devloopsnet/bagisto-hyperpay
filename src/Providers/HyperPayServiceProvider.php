<?php

namespace Devloops\HyperPay\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class HyperPayServiceProvider.
 *
 * @date 7/16/21
 *
 * @author Abdullah Al-Faqeir <abdullah@devloops.net>
 */
class HyperPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        include __DIR__.'/../Http/routes.php';

        $this->readPublishableAssets();
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'hyperpay');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'hyperpay');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * @return void
     */
    private function readPublishableAssets(): void
    {
        $this->publishes([
            __DIR__.'/../Resources/views/hyperpay' => resource_path('vendor/hyperpay'),
        ]);

        $this->publishes([__DIR__.'/../Resources/lang' => resource_path('lang/vendor/hyperpay')]);
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/Config/paymentmethods.php', 'paymentmethods');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/system.php', 'core');
    }
}
