<?php

namespace Omt\ImageHelper\Imagick\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;

class SharpenCommand extends AbstractCommand
{
    /**
     * Sharpen image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $amount = $this->argument(0)->between(0, 100)->value(10);

        return $image->getCore()->unsharpMaskImage(1, 1, $amount / 6.25, 0);
    }
}
