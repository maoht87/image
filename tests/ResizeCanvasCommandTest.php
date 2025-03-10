<?php

use Omt\ImageHelper\Gd\Commands\ResizeCanvasCommand as ResizeCanvasGd;
use Omt\ImageHelper\Imagick\Commands\ResizeCanvasCommand as ResizeCanvasImagick;
use PHPUnit\Framework\TestCase;

class ResizeCanvasCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $canvas_pos = Mockery::mock('\Omt\ImageHelper\Point', [0, 0]);
        $canvas_size = Mockery::mock('\Omt\ImageHelper\Size', [820, 640]);
        $canvas_size->shouldReceive('align')->with('center')->andReturn($canvas_size);
        $canvas_size->shouldReceive('relativePosition')->andReturn($canvas_pos);
        $image_pos = Mockery::mock('\Omt\ImageHelper\Point', [0, 0]);
        $image_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $image_size->shouldReceive('align')->with('center')->andReturn($image_size);
        $image_size->shouldReceive('relativePosition')->andReturn($image_pos);
        $canvas = Mockery::mock('\Omt\ImageHelper\Image');
        $canvas->shouldReceive('getCore')->times(5)->andReturn($resource);
        $canvas->shouldReceive('getSize')->andReturn($canvas_size);
        $driver = Mockery::mock('\Omt\ImageHelper\Gd\Driver');
        $driver->shouldReceive('newImage')->with(820, 640, '#b53717')->once()->andReturn($canvas);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new ResizeCanvasGd([20, 40, 'center', true, '#b53717']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $canvas_pos = Mockery::mock('\Omt\ImageHelper\Point', [0, 0]);
        $canvas_size = Mockery::mock('\Omt\ImageHelper\Size', [820, 640]);
        $canvas_size->shouldReceive('align')->with('center')->andReturn($canvas_size);
        $canvas_size->shouldReceive('relativePosition')->andReturn($canvas_pos);
        $image_pos = Mockery::mock('\Omt\ImageHelper\Point', [0, 0]);
        $image_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $image_size->shouldReceive('align')->with('center')->andReturn($image_size);
        $image_size->shouldReceive('relativePosition')->andReturn($image_pos);
        $canvas = Mockery::mock('\Omt\ImageHelper\Image');

        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('cropimage')->with(800, 600, 0, 0)->once();
        $imagick->shouldReceive('compositeimage')->with($imagick, 40, 0, 0)->once();
        $imagick->shouldReceive('setimagepage')->with(0, 0, 0, 0)->once();
        $imagick->shouldReceive('drawimage')->once();
        $imagick->shouldReceive('transparentpaintimage')->once();
        $imagick->shouldReceive('getimagecolorspace')->once();
        $imagick->shouldReceive('setimagecolorspace')->once();

        $canvas->shouldReceive('getCore')->times(6)->andReturn($imagick);
        $canvas->shouldReceive('getSize')->andReturn($canvas_size);
        $canvas->shouldReceive('pickColor')->with(0, 0, 'hex')->once()->andReturn('#000000');
        $driver = Mockery::mock('\Omt\ImageHelper\Gd\Driver');
        $driver->shouldReceive('newImage')->with(820, 640, '#b53717')->once()->andReturn($canvas);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('getCore')->times(3)->andReturn($imagick);
        $image->shouldReceive('setCore')->once();
        $command = new ResizeCanvasImagick([20, 40, 'center', true, '#b53717']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

}
