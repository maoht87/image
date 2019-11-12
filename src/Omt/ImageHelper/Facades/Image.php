<?php

namespace Omt\ImageHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Omt\ImageHelper\Image make(mixed $data)
 * @method static self configure(array $config)
 * @method static \Omt\ImageHelper\Image canvas(int $width, int $height, mixed $background = null)
 * @method static \Omt\ImageHelper\Image cache(\Closure $callback, int $lifetime = null, boolean $returnObj = false)
 */
class Image extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image';
    }
}
