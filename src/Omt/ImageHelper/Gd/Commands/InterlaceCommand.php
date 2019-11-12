<?php

namespace Omt\ImageHelper\Gd\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;

class InterlaceCommand extends AbstractCommand
{
    /**
     * Toggles interlaced encoding mode
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $mode = $this->argument(0)->type('bool')->value(true);

        imageinterlace($image->getCore(), $mode);

        return true;
    }
}
