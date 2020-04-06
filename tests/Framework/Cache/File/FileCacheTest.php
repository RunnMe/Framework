<?php

namespace Runn\tests\Framework\Cache\File;

use PHPUnit\Framework\TestCase;
use Runn\Framework\Cache\File\DefaultFilenameStrategy;
use Runn\Framework\Cache\File\FileCache;
use Runn\Framework\Cache\File\FilenameStrategyInterface;
use Runn\Fs\Dir;
use Runn\Serialization\SerializerInterface;
use Runn\Serialization\Serializers\Serialize;

class FileCacheTest extends TestCase
{

    public function testConstructDirArgument()
    {
        $cache = new FileCache();
        $this->assertEquals(new Dir(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cache'), $cache->getDir());

        $dir = new Dir(__DIR__ . '/cache');
        $this->assertFalse($dir->exists());

        $cache = new FileCache($dir);
        $this->assertSame($dir, $cache->getDir());
        $this->assertTrue($dir->exists());

        rmdir($dir->getRealPath());
    }

    public function testConstructFilenameStrategyArgument()
    {
        $cache = new FileCache();
        $this->assertEquals(new DefaultFilenameStrategy(), $cache->getFilenameStrategy());

        $strategy = new class implements FilenameStrategyInterface {
            public function getFileNameByKey(string $key): string
            {
                return 'foo';
            }
        };
        $cache = new FileCache(null, $strategy);
        $this->assertSame($strategy, $cache->getFilenameStrategy());
    }

    public function testConstructSerializerArgument()
    {
        $cache = new FileCache();
        $this->assertEquals(new Serialize(), $cache->getSerializer());

        $serializer = new class implements SerializerInterface {
            public function encode($data): string
            {
                return 'foo';
            }
            public function decode(string $data)
            {
                return 'bar';
            }
        };

        $cache = new FileCache(null, null, $serializer);
        $this->assertSame($serializer, $cache->getSerializer());
    }

}
