<?php

use Omt\ImageHelper\Gd\Commands\GreyscaleCommand as GreyscaleGd;
use Omt\ImageHelper\Imagick\Commands\GreyscaleCommand as GreyscaleImagick;
use PHPUnit\Framework\TestCase;

class GreyscaleCommandTest extends TestCase
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
        $command = new GreyscaleGd([]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('modulateimage')->with(100, 0, 100)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new GreyscaleImagick([]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
