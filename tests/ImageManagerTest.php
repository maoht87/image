<?php

use Omt\ImageHelper\ImageManager;
use PHPUnit\Framework\TestCase;

class ImageManagerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testConstructor()
    {
        $config = ['driver' => 'foo', 'bar' => 'baz'];
        $manager = new ImageManager($config);
        $this->assertEquals('foo', $manager->config['driver']);
        $this->assertEquals('baz', $manager->config['bar']);
    }

    public function testConfigure()
    {
        $overwrite = ['driver' => 'none', 'bar' => 'none'];
        $config = ['driver' => 'foo', 'bar' => 'baz'];
        $manager = new ImageManager($overwrite);
        $manager->configure($config);
        $this->assertEquals('foo', $manager->config['driver']);
        $this->assertEquals('baz', $manager->config['bar']);
    }

    public function testConfigureObject()
    {
        $config = ['driver' => new Omt\ImageHelper\Imagick\Driver()];
        $manager = new ImageManager($config);

        $image = $manager->make('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        $this->assertInstanceOf('Omt\ImageHelper\Image', $image);
        $this->assertInstanceOf('Imagick', $image->getCore());
    }
}
