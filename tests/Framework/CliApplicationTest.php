<?php

namespace Runn\tests\Framework\CliApplication;

use Badoo\SoftMocks;
use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Framework\CliApplication;
use Runn\Framework\Exception;

class CliApplicationTest extends TestCase
{

    protected function destroySingletonInstance(string $class)
    {
        $reflector = new \ReflectionProperty($class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null);
        $reflector->setAccessible(false);
    }

    public function testEmptyConfig()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance();

        $this->assertEquals(new Config(), $app->getConfig());
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
    }

    public function testWithoutContainer()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config());

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);

        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => 'foo']));

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);

        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => '']]));

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);
    }

    public function testInvalidContainer()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $this->expectException(Exception::class);

        $this->expectExceptionMessage('Invalid container class: ' . \stdClass::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => \stdClass::class]]));
    }

    public function testSingleton()
    {
        $app = CliApplication::instance(new Config());
        $this->assertSame($app, CliApplication::instance());
    }

    /**
     * @todo
     */
    /*
    public function testAppFunction()
    {
        $app = CliApplication::instance(new Config());
        $this->assertSame($app, app());
    }
    */

}
