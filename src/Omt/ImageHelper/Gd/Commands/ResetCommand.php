<?php

namespace Omt\ImageHelper\Gd\Commands;

use Omt\ImageHelper\Commands\AbstractCommand;
use Omt\ImageHelper\Exception\RuntimeException;

class ResetCommand extends AbstractCommand
{
    /**
     * Resets given image to its backup state
     *
     * @param  \Omt\ImageHelper\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $backupName = $this->argument(0)->value();

        if (is_resource($backup = $image->getBackup($backupName))) {

            // destroy current resource
            imagedestroy($image->getCore());

            // clone backup
            $backup = $image->getDriver()->cloneCore($backup);

            // reset to new resource
            $image->setCore($backup);

            return true;
        }

        throw new RuntimeException(
            "Backup not available. Call backup() before reset()."
        );
    }
}
