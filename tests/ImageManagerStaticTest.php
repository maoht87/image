<?php

use Omt\ImageHelper\ImageManagerStatic;
use PHPUnit\Framework\TestCase;

class ImageManagerStaticTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetManager()
    {
        $manager = Mockery::mock('Omt\ImageHelper\ImageManager');
        $managerStatic = new ImageManagerStatic($manager);
        $m = $managerStatic->getManager();
        $this->assertInstanceOf('Omt\ImageHelper\ImageManager', $m);
    }

    public function testMake()
    {
        $manager = Mockery::mock('Omt\ImageHelper\ImageManager');
        $manager->shouldReceive('make')->with('foo')->once();
        $managerStatic = new ImageManagerStatic($manager);
        $managerStatic->make('foo');
    }

    public function testCanvas()
    {
        $manager = Mockery::mock('Omt\ImageHelper\ImageManager');
        $manager->shouldReceive('canvas')->with(100, 100, null)->once();
        $managerStatic = new ImageManagerStatic($manager);
        $managerStatic->canvas(100, 100);
    }
}
