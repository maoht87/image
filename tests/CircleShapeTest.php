<?php

use Omt\ImageHelper\Gd\Shapes\CircleShape as CircleGd;
use Omt\ImageHelper\Imagick\Shapes\CircleShape as CircleImagick;
use PHPUnit\Framework\TestCase;

class CircleShapeTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGdConstructor()
    {
        $circle = new CircleGd(250);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\CircleShape', $circle);
        $this->assertEquals(250, $circle->diameter);

    }

    public function testGdApplyToImage()
    {
        $core = imagecreatetruecolor(300, 200);
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $circle = new CircleGd(250);
        $result = $circle->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\CircleShape', $circle);
        $this->assertTrue($result);
    }

    public function testImagickConstructor()
    {
        $circle = new CircleImagick(250);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\CircleShape', $circle);
        $this->assertEquals(250, $circle->width);
    }

    public function testImagickApplyToImage()
    {
        $core = Mockery::mock('\Imagick');
        $core->shouldReceive('drawimage')->once();
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $circle = new CircleImagick(250);
        $result = $circle->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\CircleShape', $circle);
        $this->assertTrue($result);
    }

}
