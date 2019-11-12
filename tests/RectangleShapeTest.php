<?php

use Omt\ImageHelper\Gd\Shapes\RectangleShape as RectangleGd;
use Omt\ImageHelper\Imagick\Shapes\RectangleShape as RectangleImagick;
use PHPUnit\Framework\TestCase;

class RectangleShapeTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testConstructor()
    {
        // gd
        $rectangle = new RectangleGd(10, 15, 100, 150);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\RectangleShape', $rectangle);
        $this->assertEquals(10, $rectangle->x1);
        $this->assertEquals(15, $rectangle->y1);
        $this->assertEquals(100, $rectangle->x2);
        $this->assertEquals(150, $rectangle->y2);

        // imagick
        $rectangle = new RectangleImagick(10, 15, 100, 150);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\RectangleShape', $rectangle);
        $this->assertEquals(10, $rectangle->x1);
        $this->assertEquals(15, $rectangle->y1);
        $this->assertEquals(100, $rectangle->x2);
        $this->assertEquals(150, $rectangle->y2);
    }

    public function testApplyToImage()
    {
        // gd
        $core = imagecreatetruecolor(300, 200);
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $rectangle = new RectangleGd(10, 15, 100, 150);
        $result = $rectangle->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\RectangleShape', $rectangle);
        $this->assertTrue($result);

        // imagick
        $core = Mockery::mock('\Imagick');
        $core->shouldReceive('drawimage')->once();
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $rectangle = new RectangleImagick(10, 15, 100, 150);
        $result = $rectangle->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\RectangleShape', $rectangle);
        $this->assertTrue($result);
    }
}
