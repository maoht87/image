<?php

namespace Omt\ImageHelper\Imagick\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;

class PixelateCommand extends AbstractCommand
{
    /**
     * Applies a pixelation effect to a given image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $size = $this->argument(0)->type('digit')->value(10);

        $width = $image->getWidth();
        $height = $image->getHeight();

        $image->getCore()->scaleImage(max(1, ($width / $size)), max(1, ($height / $size)));
        $image->getCore()->scaleImage($width, $height);

        return true;
    }
}
