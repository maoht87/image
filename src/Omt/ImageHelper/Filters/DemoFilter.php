<?php

namespace Omt\ImageHelper\Filters;

use Omt\ImageHelper\Image;

class DemoFilter implements FilterInterface
{
    /**
     * Default size of filter effects
     */
    const DEFAULT_SIZE = 10;

    /**
     * Size of filter effects
     *
     * @var int
     */
    private $size;

    /**
     * Creates new instance of filter
     *
     * @param int $size
     */
    public function __construct($size = null)
    {
        $this->size = is_numeric($size) ? intval($size) : self::DEFAULT_SIZE;
    }

    /**
     * Applies filter effects to given image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return \Omt\ImageHelper\Image
     */
    public function applyFilter(Image $image)
    {
        $image->pixelate($this->size);
        $image->greyscale();

        return $image;
    }
}
