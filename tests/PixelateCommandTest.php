<?php

use Omt\ImageHelper\Gd\Commands\PixelateCommand as PixelateGd;
use Omt\ImageHelper\Imagick\Commands\PixelateCommand as PixelateImagick;
use PHPUnit\Framework\TestCase;

class PixelateCommandTest extends TestCase
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
        $command = new PixelateGd([10]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('scaleimage')->with(80, 60)->once()->andReturn(true);
        $imagick->shouldReceive('scaleimage')->with(800, 600)->once()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->times(2)->andReturn($imagick);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $command = new PixelateImagick([10]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
