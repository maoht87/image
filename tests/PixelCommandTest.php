<?php

use Omt\ImageHelper\Gd\Commands\PixelCommand as PixelGd;
use Omt\ImageHelper\Imagick\Commands\PixelCommand as PixelImagick;
use PHPUnit\Framework\TestCase;

class PixelCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $command = new PixelGd(['#b53717', 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('drawimage')->once()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new PixelImagick(['#b53717', 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
