<?php

use Omt\ImageHelper\Gd\Shapes\LineShape as LineGd;
use Omt\ImageHelper\Imagick\Shapes\LineShape as LineImagick;
use PHPUnit\Framework\TestCase;

class LineShapeTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testConstructor()
    {
        // gd
        $line = new LineGd(10, 15);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\LineShape', $line);
        $this->assertEquals(10, $line->x);
        $this->assertEquals(15, $line->y);

        // imagick
        $line = new LineImagick(10, 15);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\LineShape', $line);
        $this->assertEquals(10, $line->x);
        $this->assertEquals(15, $line->y);
    }

    public function testApplyToImage()
    {
        // gd
        $core = imagecreatetruecolor(300, 200);
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $line = new LineGd(10, 15);
        $result = $line->applyToImage($image, 100, 200);
        $this->assertInstanceOf('Omt\ImageHelper\Gd\Shapes\LineShape', $line);
        $this->assertTrue($result);

        // imagick
        $core = Mockery::mock('\Imagick');
        $core->shouldReceive('drawimage')->once();
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $image->shouldReceive('getCore')->once()->andReturn($core);
        $line = new LineImagick(10, 15);
        $result = $line->applyToImage($image, 100, 200);
        $this->assertInstanceOf('Omt\ImageHelper\Imagick\Shapes\LineShape', $line);
        $this->assertTrue($result);
    }
}
