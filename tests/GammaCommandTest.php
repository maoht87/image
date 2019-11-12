<?php

use Omt\ImageHelper\Gd\Commands\GammaCommand as GammaGd;
use Omt\ImageHelper\Imagick\Commands\GammaCommand as GammaImagick;
use PHPUnit\Framework\TestCase;

class GammaCommandTest extends TestCase
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
        $command = new GammaGd([1.4]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('gammaimage')->with(1.4)->once()->andReturn(true);
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $command = new GammaImagick([1.4]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
