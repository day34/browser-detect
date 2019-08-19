<?php

namespace hisorange\BrowserDetect;

use Illuminate\Support\Facades\Blade;

/**
 * Class ServiceProvider
 * @package hisorange\BrowserDetect
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function isDeferred()
    {
        return true;
    }

    /**
     * Register the custom blade directives.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/browser-detect.php' => config_path('browser-detect.php'),
        ]);

        $this->registerDirectives();
    }

    /**
     * Register the blade directives.
     */
    protected function registerDirectives()
    {
        if (version_compare($this->app->version(), '5.5', '>=')) {
            // Workaround to support the PHP5.6 syntax.
            // Even tho the laravel version will lock to 7.0 >=
            // but the code is still complied and throws syntax error on 5.6.
            require 'Legacy/Blade.php';
        }
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton('browser-detect', Parser::class);
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['browser-detect'];
    }
}