<?php

namespace Omt\ImageHelper\Imagick\Commands;

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

        if ($mode) {
            $mode = \Imagick::INTERLACE_LINE;
        } else {
            $mode = \Imagick::INTERLACE_NO;
        }

        $image->getCore()->setInterlaceScheme($mode);

        return true;
    }
}
