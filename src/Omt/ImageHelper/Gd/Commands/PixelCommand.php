<?php

namespace Omt\ImageHelper\Gd\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;
use Omt\ImageHelper\Gd\Color;

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

        return imagesetpixel($image->getCore(), $x, $y, $color->getInt());
    }
}
