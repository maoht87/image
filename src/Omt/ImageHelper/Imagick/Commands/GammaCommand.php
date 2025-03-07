<?php

namespace Omt\ImageHelper\Imagick\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;

class GammaCommand extends AbstractCommand
{
    /**
     * Applies gamma correction to a given image
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $gamma = $this->argument(0)->type('numeric')->required()->value();

        return $image->getCore()->gammaImage($gamma);
    }
}
