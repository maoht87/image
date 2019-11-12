<?php

namespace Omt\ImageHelper;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as IlluminateApplication;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Actual provider
     *
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->provider = $this->getProvider();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this->provider, 'boot')) {
            return $this->provider->boot();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return $this->provider->register();
    }

    /**
     * Return ServiceProvider according to Laravel version
     *
     * @return \Omt\ImageHelper\Provider\ProviderInterface
     */
    private function getProvider()
    {
        if ($this->app instanceof LumenApplication) {
            $provider = '\Omt\ImageHelper\ImageServiceProviderLumen';
        } elseif (version_compare(IlluminateApplication::VERSION, '5.0', '<')) {
            $provider = '\Omt\ImageHelper\ImageServiceProviderLaravel4';
        } else {
            $provider = '\Omt\ImageHelper\ImageServiceProviderLaravelRecent';
        }

        return new $provider($this->app);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['image'];
    }
}
