<?php

namespace Omt\ImageHelper\Imagick\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;
use Omt\ImageHelper\Imagick\Color;

class PixelCommand extends AbstractCommand
{
    /**
     * Draws one pixel to a given image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $color = $this->argument(0)->required()->value();
        $color = new Color($color);
        $x = $this->argument(1)->type('digit')->required()->value();
        $y = $this->argument(2)->type('digit')->required()->value();

        // prepare pixel
        $draw = new \ImagickDraw;
        $draw->setFillColor($color->getPixel());
        $draw->point($x, $y);

        // apply pixel
        return $image->getCore()->drawImage($draw);
    }
}
