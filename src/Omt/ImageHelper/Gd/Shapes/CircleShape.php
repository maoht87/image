<?php

namespace Omt\ImageHelper\Gd\Shapes;

use Omt\ImageHelper\Image;

class CircleShape extends EllipseShape
{
    /**
     * Diameter of circle in pixels
     *
     * @var int
     */
    public $diameter = 100;

    /**
     * Create new instance of circle
     *
     * @param int $diameter
     */
    public function __construct($diameter = null)
    {
        $this->width = is_numeric($diameter) ? intval($diameter) : $this->diameter;
        $this->height = is_numeric($diameter) ? intval($diameter) : $this->diameter;
        $this->diameter = is_numeric($diameter) ? intval($diameter) : $this->diameter;
    }

    /**
     * Draw current circle on given image
     *
     * @param  Image   $image
     * @param  int     $x
     * @param  int     $y
     * @return boolean
     */
    public function applyToImage(Image $image, $x = 0, $y = 0)
    {
        return parent::applyToImage($image, $x, $y);
    }
}
