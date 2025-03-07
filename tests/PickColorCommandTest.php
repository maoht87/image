<?php

use Omt\ImageHelper\Gd\Commands\PickColorCommand as PickColorGd;
use Omt\ImageHelper\Imagick\Commands\PickColorCommand as PickColorImagick;
use PHPUnit\Framework\TestCase;

class PickColorCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGdWithCoordinates()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->times(2)->andReturn($resource);
        $command = new PickColorGd([1, 2]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInternalType('array', $command->getOutput());
        $this->assertEquals(4, count($command->getOutput()));
    }

    public function testGdWithFormat()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->times(2)->andReturn($resource);
        $command = new PickColorGd([1, 2, 'hex']);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInternalType('string', $command->getOutput());
        $this->assertEquals('#ffffff', $command->getOutput());
    }

    public function testImagickWithCoordinates()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('getimagepixelcolor')->with(1, 2)->andReturn(new ImagickPixel);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new PickColorImagick([1, 2]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInternalType('array', $command->getOutput());
        $this->assertEquals(4, count($command->getOutput()));
    }

    public function testImagickWithFormat()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('getimagepixelcolor')->with(1, 2)->andReturn(new ImagickPixel('#ff0000'));
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new PickColorImagick([1, 2, 'hex']);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertInternalType('string', $command->getOutput());
        $this->assertEquals('#ff0000', $command->getOutput());
    }
}
