<?php

namespace Runn\tests\Framework\WebApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Framework\Exception;
use Runn\Framework\WebApplication;


class WebApplicationTest extends TestCase
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
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance();

        $this->assertEquals(new Config(), $app->getConfig());
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
    }

    public function testWithoutContainer()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config());

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);

        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => 'foo']));

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);

        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => '']]));

        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
        $this->assertFalse(isset($app->service));
        $this->assertNull($app->service);
    }

    public function testInvalidContainer()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $this->expectException(Exception::class);

        $this->expectExceptionMessage('Invalid container class: ' . \stdClass::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => \stdClass::class]]));
    }

    public function testWithoutRouter()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config());

        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());

        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['router' => 'foo']));

        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());

        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['router' => ['class' => '']]));

        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());
    }

    public function testInvalidRouter()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid router class: ' . \stdClass::class);

        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['router' => ['class' => \stdClass::class]]));
    }

    public function testSingleton()
    {
        $app = WebApplication::instance(new Config());
        $this->assertSame($app, WebApplication::instance());
    }

    public function testAppFunction()
    {
        $app = WebApplication::instance(new Config());
        $this->assertSame($app, app());
    }

}
