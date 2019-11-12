<?php

use Omt\ImageHelper\Gd\Shapes\EllipseShape as EllipseGd;
use Omt\ImageHelper\Imagick\Shapes\EllipseShape as EllipseImagick;
use PHPUnit\Framework\TestCase;

class EllipseShapeTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGdConstructor()
    {
        $ellipse = new EllipseGd(250, 150);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\EllipseShape', $ellipse);
        $this->assertEquals(250, $ellipse->width);
        $this->assertEquals(150, $ellipse->height);

    }

    public function testGdApplyToImage()
    {
        $core = imagecreatetruecolor(300, 200);
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $ellipse = new EllipseGd(250, 150);
        $result = $ellipse->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\EllipseShape', $ellipse);
        $this->assertTrue($result);
    }

    public function testImagickConstructor()
    {
        $ellipse = new EllipseImagick(250, 150);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\EllipseShape', $ellipse);
        $this->assertEquals(250, $ellipse->width);
        $this->assertEquals(150, $ellipse->height);

    }

    public function testImagickApplyToImage()
    {
        $core = Mockery::mock('\Imagick');
        $core->shouldReceive('drawimage')->once();
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $ellipse = new EllipseImagick(250, 150);
        $result = $ellipse->applyToImage($image, 10, 20);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\EllipseShape', $ellipse);
        $this->assertTrue($result);
    }

}
