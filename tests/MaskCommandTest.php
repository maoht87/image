<?php

use Omt\ImageHelper\Gd\Commands\MaskCommand as MaskGd;
use Omt\ImageHelper\Imagick\Commands\MaskCommand as MaskImagick;
use PHPUnit\Framework\TestCase;

class MaskCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $mask_path = __DIR__.'images/star.png';
        $mask_image = Mockery::mock('Omt\ImageHelper\Image');
        $mask_size = Mockery::mock('Omt\ImageHelper\Size', [32, 32]);
        $mask_image->shouldReceive('getSize')->once()->andReturn($mask_size);
        $mask_image->shouldReceive('pickColor')->andReturn([0,0,0,0]);

        $canvas_image = Mockery::mock('Omt\ImageHelper\Image');
        $canvas_core = imagecreatetruecolor(32, 32);
        $canvas_image->shouldReceive('getCore')->times(2)->andReturn($canvas_core);
        $canvas_image->shouldReceive('pixel');

        $driver = Mockery::mock('Omt\ImageHelper\Gd\Driver');
        $driver->shouldReceive('newImage')->with(32, 32, [0,0,0,0])->once()->andReturn($canvas_image);
        $driver->shouldReceive('init')->with($mask_path)->once()->andReturn($mask_image);

        $image_size = Mockery::mock('Omt\ImageHelper\Size', [32, 32]);
        $image_core = imagecreatefrompng(__DIR__.'/images/trim.png');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $image->shouldReceive('getDriver')->times(2)->andReturn($driver);
        $image->shouldReceive('pickColor')->andReturn([0,0,0,0]);
        $image->shouldReceive('setCore')->with($canvas_core)->once();

        $command = new MaskGd([$mask_path, true]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $mask_core = Mockery::mock('Imagick');
        $mask_path = __DIR__.'images/star.png';
        $mask_image = Mockery::mock('Omt\ImageHelper\Image');
        $mask_image->shouldReceive('getCore')->once()->andReturn($mask_core);
        $mask_size = Mockery::mock('Omt\ImageHelper\Size', [32, 32]);
        $mask_image->shouldReceive('getSize')->once()->andReturn($mask_size);

        $driver = Mockery::mock('Omt\ImageHelper\Imagick\Driver');
        $driver->shouldReceive('init')->with($mask_path)->once()->andReturn($mask_image);
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('setimagematte')->with(true)->once();
        $imagick->shouldReceive('compositeimage')->with($mask_core, \Imagick::COMPOSITE_DSTIN, 0, 0)->once();
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $image_size = Mockery::mock('Omt\ImageHelper\Size', [32, 32]);
        $image->shouldReceive('getSize')->once()->andReturn($image_size);
        $image->shouldReceive('getDriver')->once()->andReturn($driver);

        $command = new MaskImagick([$mask_path, true]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
