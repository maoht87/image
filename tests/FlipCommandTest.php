<?php

use Omt\ImageHelper\Gd\Commands\FlipCommand as FlipGd;
use Omt\ImageHelper\Imagick\Commands\FlipCommand as FlipImagick;
use PHPUnit\Framework\TestCase;

class FlipCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($size);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new FlipGd(['h']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('flopimage')->with()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new FlipImagick(['h']);
        $result = $command->execute($image);
        $this->assertTrue($result);

        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('flipimage')->with()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new FlipImagick(['v']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
