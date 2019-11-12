<?php

use Omt\ImageHelper\Gd\Commands\FitCommand as FitGd;
use Omt\ImageHelper\Imagick\Commands\FitCommand as FitImagick;
use PHPUnit\Framework\TestCase;

class FitCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGdFit()
    {
        $cropped_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 400]);
        $cropped_size->shouldReceive('getWidth')->times(2)->andReturn(800);
        $cropped_size->shouldReceive('getHeight')->times(2)->andReturn(400);
        $cropped_size->shouldReceive('resize')->with(200, 100, null)->once()->andReturn($cropped_size);
        $cropped_size->pivot = Mockery::mock('\Omt\ImageHelper\Point', [0, 100]);
        $original_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $original_size->shouldReceive('fit')->with(Mockery::any(), 'center')->once()->andReturn($cropped_size);
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($original_size);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new FitGd([200, 100]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testGdFitWithPosition()
    {
        $cropped_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 400]);
        $cropped_size->shouldReceive('getWidth')->times(2)->andReturn(800);
        $cropped_size->shouldReceive('getHeight')->times(2)->andReturn(400);
        $cropped_size->shouldReceive('resize')->with(200, 100, null)->once()->andReturn($cropped_size);
        $cropped_size->pivot = Mockery::mock('\Omt\ImageHelper\Point', [0, 100]);
        $original_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $original_size->shouldReceive('fit')->with(Mockery::any(), 'top-left')->once()->andReturn($cropped_size);
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($original_size);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new FitGd([200, 100, null, 'top-left']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagickFit()
    {
        $cropped_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 400]);
        $cropped_size->shouldReceive('getWidth')->once()->andReturn(200);
        $cropped_size->shouldReceive('getHeight')->once()->andReturn(100);
        $cropped_size->shouldReceive('resize')->with(200, 100, null)->once()->andReturn($cropped_size);
        $cropped_size->pivot = Mockery::mock('\Omt\ImageHelper\Point', [0, 100]);
        $original_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $original_size->shouldReceive('fit')->with(Mockery::any(), 'center')->once()->andReturn($cropped_size);
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('cropimage')->with(800, 400, 0, 100)->andReturn(true);
        $imagick->shouldReceive('scaleimage')->with(200, 100)->once()->andReturn(true);
        $imagick->shouldReceive('setimagepage')->with(0, 0, 0, 0)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($original_size);
        $image->shouldReceive('getCore')->times(3)->andReturn($imagick);
        $command = new FitImagick([200, 100]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagickFitWithPosition()
    {
        $cropped_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 400]);
        $cropped_size->shouldReceive('getWidth')->once()->andReturn(200);
        $cropped_size->shouldReceive('getHeight')->once()->andReturn(100);
        $cropped_size->shouldReceive('resize')->with(200, 100, null)->once()->andReturn($cropped_size);
        $cropped_size->pivot = Mockery::mock('\Omt\ImageHelper\Point', [0, 100]);
        $original_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $original_size->shouldReceive('fit')->with(Mockery::any(), 'top-left')->once()->andReturn($cropped_size);
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('cropimage')->with(800, 400, 0, 100)->andReturn(true);
        $imagick->shouldReceive('scaleimage')->with(200, 100)->once()->andReturn(true);
        $imagick->shouldReceive('setimagepage')->with(0, 0, 0, 0)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($original_size);
        $image->shouldReceive('getCore')->times(3)->andReturn($imagick);
        $command = new FitImagick([200, 100, null, 'top-left']);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
