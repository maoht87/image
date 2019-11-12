<?php

use Omt\ImageHelper\Gd\Driver as GdDriver;
use Omt\ImageHelper\Imagick\Driver as ImagickDriver;
use PHPUnit\Framework\TestCase;

class DriverTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testNewImageGd()
    {
        $driver = new GdDriver(
            Mockery::mock('\Omt\ImageHelper\Gd\Decoder'),
            Mockery::mock('\Omt\ImageHelper\Gd\Encoder')
        );

        $image = $driver->newImage(300, 200, '00ff00');
        $this->assertInstanceOf('\Omt\ImageHelper\Image', $image);
        $this->assertInstanceOf('\Omt\ImageHelper\Gd\Driver', $image->getDriver());
        $this->assertInternalType('resource', $image->getCore());
    }

    public function testNewImageImagick()
    {
        $driver = new ImagickDriver(
            Mockery::mock('\Omt\ImageHelper\Imagick\Decoder'),
            Mockery::mock('\Omt\ImageHelper\Imagick\Encoder')
        );

        $image = $driver->newImage(300, 200, '00ff00');
        $this->assertInstanceOf('\Omt\ImageHelper\Image', $image);
        $this->assertInstanceOf('\Omt\ImageHelper\Imagick\Driver', $image->getDriver());
        $this->assertInstanceOf('\Imagick', $image->getCore());
    }

    public function testParseColorGd()
    {
        $driver = new GdDriver(
            Mockery::mock('\Omt\ImageHelper\Gd\Decoder'),
            Mockery::mock('\Omt\ImageHelper\Gd\Encoder')
        );

        $color = $driver->parseColor('00ff00');
        $this->assertInstanceOf('\Omt\ImageHelper\Gd\Color', $color);
    }

    public function testParseColorImagick()
    {
        $driver = new ImagickDriver(
            Mockery::mock('\Omt\ImageHelper\Imagick\Decoder'),
            Mockery::mock('\Omt\ImageHelper\Imagick\Encoder')
        );

        $color = $driver->parseColor('00ff00');
        $this->assertInstanceOf('\Omt\ImageHelper\Imagick\Color', $color);
    }
}
