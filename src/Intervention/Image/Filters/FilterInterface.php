<?php

namespace Omt\ImageHelper\Filters;

use Omt\ImageHelper\Image;

interface FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return \Omt\ImageHelper\Image
     */
    public function applyFilter(Image $image);
}
