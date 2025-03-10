<?php

namespace Omt\ImageHelper\Imagick\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;
use Omt\ImageHelper\Exception\InvalidArgumentException;
use Omt\ImageHelper\Point;
use Omt\ImageHelper\Size;

class CropCommand extends AbstractCommand
{
    /**
     * Crop an image instance
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $width = $this->argument(0)->type('digit')->required()->value();
        $height = $this->argument(1)->type('digit')->required()->value();
        $x = $this->argument(2)->type('digit')->value();
        $y = $this->argument(3)->type('digit')->value();

        if (is_null($width) || is_null($height)) {
            throw new InvalidArgumentException(
                "Width and height of cutout needs to be defined."
            );
        }

        $cropped = new Size($width, $height);
        $position = new Point($x, $y);

        // align boxes
        if (is_null($x) && is_null($y)) {
            $position = $image->getSize()->align('center')->relativePosition($cropped->align('center'));
        }

        // crop image core
        $image->getCore()->cropImage($cropped->width, $cropped->height, $position->x, $position->y);
        $image->getCore()->setImagePage(0,0,0,0);

        return true;
    }
}
