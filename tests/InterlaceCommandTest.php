<?php

use Omt\ImageHelper\Gd\Commands\InterlaceCommand as InterlaceGd;
use Omt\ImageHelper\Imagick\Commands\InterlaceCommand as InterlaceImagick;
use PHPUnit\Framework\TestCase;

class InterlaceCommandTest extends TestCase
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
        $command = new InterlaceGd([true]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('setinterlacescheme')->with(\Imagick::INTERLACE_LINE)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new InterlaceImagick([true]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
