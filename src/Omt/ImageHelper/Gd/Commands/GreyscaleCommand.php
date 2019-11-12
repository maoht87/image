<?php

namespace Omt\ImageHelper\Gd\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;

class GreyscaleCommand extends AbstractCommand
{
    /**
     * Turns an image into a greyscale version
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_GRAYSCALE);
    }
}
