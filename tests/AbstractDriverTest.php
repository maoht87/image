<?php

use PHPUnit\Framework\TestCase;

class AbstractDriverTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @expectedException \Omt\ImageHelper\Exception\NotSupportedException
     */
    public function testExecuteCommand()
    {
        $image = Mockery::mock('Omt\ImageHelper\Image');
        $driver = $this->getMockForAbstractClass('\Omt\ImageHelper\AbstractDriver');
        $command = $driver->executeCommand($image, 'xxxxxxxxxxxxxxxxxxxxxxx', []);
    }
}
