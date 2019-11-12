<?php

use Omt\ImageHelper\Gd\Commands\InsertCommand as InsertGd;
use Omt\ImageHelper\Imagick\Commands\InsertCommand as InsertImagick;
use PHPUnit\Framework\TestCase;

class InsertCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $position = Mockery::mock('\Omt\ImageHelper\Point', [0, 0]);

        $image_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $image_size->shouldReceive('align')->with('center', 10, 20)->once()->andReturn($image_size);
        $watermark_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $watermark_size->shouldReceive('align')->with('center')->once()->andReturn($watermark_size);
        $image_size->shouldReceive('relativePosition')->with($watermark_size)->once()->andReturn($position);

        $path = __DIR__.'/images/test.jpg';
        $resource = imagecreatefromjpeg($path);
        $watermark = Mockery::mock('Omt\ImageHelper\Image');
        $driver = Mockery::mock('Omt\ImageHelper\Gd\Driver');
        $driver->shouldReceive('init')->with($path)->once()->andReturn($watermark);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getCore')->times(2)->andReturn($resource);
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $watermark->shouldReceive('getSize')->once()->andReturn($watermark_size);
        $watermark->shouldReceive('getCore')->once()->andReturn($resource);

        $command = new InsertGd([$path, 'center', 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $position = Mockery::mock('\Omt\ImageHelper\Point', [10, 20]);

        $image_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $image_size->shouldReceive('align')->with('center', 10, 20)->once()->andReturn($image_size);
        $watermark_size = Mockery::mock('\Omt\ImageHelper\Size', [800, 600]);
        $watermark_size->shouldReceive('align')->with('center')->once()->andReturn($watermark_size);
        $image_size->shouldReceive('relativePosition')->with($watermark_size)->once()->andReturn($position);

        $path = __DIR__.'/images/test.jpg';
        $watermark = Mockery::mock('Omt\ImageHelper\Image');
        $driver = Mockery::mock('Omt\ImageHelper\Imagick\Driver');
        $driver->shouldReceive('init')->with($path)->once()->andReturn($watermark);
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('compositeimage')->with($imagick, \Imagick::COMPOSITE_DEFAULT, 10, 20)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $watermark->shouldReceive('getSize')->once()->andReturn($watermark_size);
        $watermark->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new InsertImagick([$path, 'center', 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
