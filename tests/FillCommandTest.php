<?php

use Omt\ImageHelper\Gd\Commands\FillCommand as FillGd;
use Omt\ImageHelper\Imagick\Commands\FillCommand as FillImagick;
use PHPUnit\Framework\TestCase;

class FillCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGdFill()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $command = new FillGd(['666666']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testGdFillArray()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $command = new FillGd([[50, 50, 50]]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testGdFillArrayWithAlpha()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $command = new FillGd([[50, 50, 50, .50]]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testGdFillWithCoordinates()
    {
        $driver = Mockery::mock('\Omt\ImageHelper\Gd\Driver');
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getCore')->times(2)->andReturn($resource);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('setCore')->once();
        $driver->shouldReceive('newImage')->with(800, 600)->once()->andReturn($image);
        $command = new FillGd(['#666666', 0, 0]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagickFill()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('drawimage')->once()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('getCore')->andReturn($imagick);
        $command = new FillImagick(['666666']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagickFillWithCoordinates()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('getimagepixelcolor')->once()->andReturn('#000000');
        $imagick->shouldReceive('transparentpaintimage')->once()->andReturn(true);
        $imagick->shouldReceive('compositeimage')->times(3)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->andReturn($imagick);
        $image->shouldReceive('getWidth')->andReturn(800);
        $image->shouldReceive('getHeight')->andReturn(600);
        $command = new FillImagick(['666666', 0, 0]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
