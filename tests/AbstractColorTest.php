<?php

use PHPUnit\Framework\TestCase;

class AbstractColorTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @expectedException \Omt\ImageHelper\Exception\NotSupportedException
     */
    public function testFormatUnknown()
    {
        $color = $this->getMockForAbstractClass('\Omt\ImageHelper\AbstractColor');
        $color->format('xxxxxxxxxxxxxxxxxxxxxxx');
    }
}
