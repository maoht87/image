<?php

namespace Omt\ImageHelper;

use League\Container\ServiceProvider\AbstractServiceProvider;

class ImageServiceProviderLeague extends AbstractServiceProvider
{
    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var array $provides
     */
    protected $provides = [
        'Omt\ImageHelper\ImageManager'
    ];

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Register the server provider.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->share('Omt\ImageHelper\ImageManager', function () {
            return new ImageManager($this->config);
        });
    }
}
