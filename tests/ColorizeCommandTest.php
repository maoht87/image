<?php

use Omt\ImageHelper\Gd\Commands\ColorizeCommand as ColorizeGd;
use Omt\ImageHelper\Imagick\Commands\ColorizeCommand as ColorizeImagick;
use PHPUnit\Framework\TestCase;

class ColorizeCommandTest extends TestCase
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
        $command = new ColorizeGd([20, 0, -40]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('getquantumrange')->with()->once()->andReturn(['quantumRangeLong' => 42]);
        $imagick->shouldReceive('levelimage')->with(0, 4, 42, \Imagick::CHANNEL_RED)->once()->andReturn(true);
        $imagick->shouldReceive('levelimage')->with(0, 1, 42, \Imagick::CHANNEL_GREEN)->once()->andReturn(true);
        $imagick->shouldReceive('levelimage')->with(0, 0.6, 42, \Imagick::CHANNEL_BLUE)->once()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->times(4)->andReturn($imagick);
        $command = new ColorizeImagick([20, 0, -40]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
