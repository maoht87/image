<?php

use Omt\ImageHelper\Gd\Commands\BrightnessCommand as BrightnessGd;
use Omt\ImageHelper\Imagick\Commands\BrightnessCommand as BrightnessImagick;
use PHPUnit\Framework\TestCase;

class BrightnessCommandTest extends TestCase
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
        $command = new BrightnessGd([12]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('modulateimage')->with(112, 100, 100)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new BrightnessImagick([12]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
