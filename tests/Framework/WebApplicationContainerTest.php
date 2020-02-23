<?php

namespace Runn\tests\Framework\WebApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Di\Container;
use Runn\Di\ContainerInterface;
use Runn\Di\ContainerTrait;
use Runn\Framework\WebApplication;

class testContainerWithConstruct implements ContainerInterface {
    use ContainerTrait;
    public function __construct(Config $config) {
        foreach ($config as $key => $val) {
            echo $key . '=>' . $val;
        }
    }
}

class WebApplicationContainerTest extends TestCase
{

    protected function destroySingletonInstance(string $class)
    {
        $reflector = new \ReflectionProperty($class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null);
        $reflector->setAccessible(false);
    }

    public function testDefaultContainer()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => Container::class]]));

        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new Container(), $app->getContainer());
    }

    public function testContainerWithConstruct()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => testContainerWithConstruct::class]]));

        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new testContainerWithConstruct(new Config()), $app->getContainer());

        $this->expectOutputString('foo=>barbaz=>42foo=>barbaz=>42');
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => [
            'class' => testContainerWithConstruct::class,
            'foo' => 'bar',
            'baz' => 42
        ]]));
        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new testContainerWithConstruct(new Config(['foo' => 'bar', 'baz' => 42])), $app->getContainer());
    }

}
