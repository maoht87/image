<?php

use Omt\ImageHelper\Gd\Commands\SharpenCommand as SharpenGd;
use Omt\ImageHelper\Imagick\Commands\SharpenCommand as SharpenImagick;
use PHPUnit\Framework\TestCase;

class SharpenCommandTest extends TestCase
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
        $command = new SharpenGd([50]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('unsharpmaskimage')->with(1, 1, 8, 0)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new SharpenImagick([50]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
