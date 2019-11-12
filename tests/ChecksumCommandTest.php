<?php

use Omt\ImageHelper\Commands\ChecksumCommand;
use PHPUnit\Framework\TestCase;

class ChecksumCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testExecute()
    {
        $size = Mockery::mock('Omt\ImageHelper\Size', [3, 3]);
        $color = [0,0,0,1];
        $resource = imagecreatefrompng(__DIR__.'/images/tile.png');
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $image->shouldReceive('getSize')->once()->andReturn($size);
        $image->shouldReceive('pickColor')->times(9)->andReturn($color);
        $command = new ChecksumCommand([]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());
        $this->assertEquals('ec9cbdb71be04e26b4a89333f20c273b', $command->getOutput());
    }
}
