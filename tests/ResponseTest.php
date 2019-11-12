<?php

use Omt\ImageHelper\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testConstructor()
    {
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $response = new Response($image);
        $this->assertInstanceOf('\Omt\ImageHelper\Response', $response);
        $this->assertInstanceOf('\Omt\ImageHelper\Image', $response->image);
    }

    public function testConstructorWithParameters()
    {
        $image = Mockery::mock('\Omt\ImageHelper\Image');
        $response = new Response($image, 'jpg', 75);
        $this->assertInstanceOf('\Omt\ImageHelper\Response', $response);
        $this->assertInstanceOf('\Omt\ImageHelper\Image', $response->image);
        $this->assertEquals('jpg', $response->format);
        $this->assertEquals(75, $response->quality);
    }
}
