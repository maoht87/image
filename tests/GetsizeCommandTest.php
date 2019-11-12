<?php

use Omt\ImageHelper\Gd\Commands\GetSizeCommand as GetSizeGd;
use Omt\ImageHelper\Imagick\Commands\GetSizeCommand as GetSizeImagick;
use PHPUnit\Framework\TestCase;

class GetsizeCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->times(2)->andReturn($resource);
        $command = new GetSizeGd([]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInstanceOf('Omt\ImageHelper\Size', $command->getOutput());
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('getimagewidth')->with();
        $imagick->shouldReceive('getimageheight')->with();
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new GetSizeImagick([]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInstanceOf('Omt\ImageHelper\Size', $command->getOutput());
    }
}
