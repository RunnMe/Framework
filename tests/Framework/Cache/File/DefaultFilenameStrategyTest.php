<?php

namespace Runn\tests\Framework\Cache\File;

use PHPUnit\Framework\TestCase;
use Runn\Framework\Cache\File\DefaultFilenameStrategy;
use Runn\Framework\Cache\File\FilenameStrategyInterface;
use Runn\Framework\Cache\InvalidCacheKeyException;

class DefaultFilenameStrategyTest extends TestCase
{

    public function testEmptyKey()
    {
        $strategy = new DefaultFilenameStrategy();
        $this->assertInstanceOf(FilenameStrategyInterface::class, $strategy);

        $this->expectException(InvalidCacheKeyException::class);
        $strategy->getFileNameByKey('');
    }

    public function testFooKey()
    {
        $strategy = new DefaultFilenameStrategy();
        $this->assertInstanceOf(FilenameStrategyInterface::class, $strategy);

        $result = $strategy->getFileNameByKey('foo');
        $this->assertSame('2c' . DIRECTORY_SEPARATOR . '26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae', $result);
    }

}
