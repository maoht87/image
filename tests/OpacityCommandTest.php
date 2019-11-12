<?php

use Omt\ImageHelper\Gd\Commands\OpacityCommand as OpacityGd;
use Omt\ImageHelper\Imagick\Commands\OpacityCommand as OpacityImagick;
use PHPUnit\Framework\TestCase;

class OpacityCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGd()
    {
        $mask_core = imagecreatetruecolor(32, 32);
        $mask = Mockery::mock('\Omt\ImageHelper\Image');
        $mask->shouldReceive('getCore')->once()->andReturn($mask_core);

        $resource = imagecreatefrompng(__DIR__.'/images/trim.png');
        $driver = Mockery::mock('\Omt\ImageHelper\Gd\Driver');
        $driver->shouldReceive('newImage')->with(32, 32, 'rgba(0, 0, 0, 0.5)')->andReturn($mask);

        $size = Mockery::mock('\Omt\ImageHelper\Size', [32, 32]);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getSize')->once()->andReturn($size);
        $image->shouldReceive('mask')->with($mask_core, true)->once();
        $command = new OpacityGd([50]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('evaluateimage')->with(\Imagick::EVALUATE_DIVIDE, 2, \Imagick::CHANNEL_ALPHA)->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new OpacityImagick([50]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
