<?php

use Omt\ImageHelper\Gd\Commands\ContrastCommand as ContrastGd;
use Omt\ImageHelper\Imagick\Commands\ContrastCommand as ContrastImagick;
use PHPUnit\Framework\TestCase;

class ContrastCommandTest extends TestCase
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
        $command = new ContrastGd([20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('sigmoidalcontrastimage')->with(true, 5, 0)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new ContrastImagick([20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
