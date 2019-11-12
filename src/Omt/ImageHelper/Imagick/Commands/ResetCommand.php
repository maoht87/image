<?php

namespace Omt\ImageHelper\Imagick\Commands;

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

        $backup = $image->getBackup($backupName);

        if ($backup instanceof \Imagick) {

            // destroy current core
            $image->getCore()->clear();

            // clone backup
            $backup = clone $backup;

            // reset to new resource
            $image->setCore($backup);

            return true;
        }

        throw new RuntimeException(
            "Backup not available. Call backup({$backupName}) before reset()."
        );
    }
}
