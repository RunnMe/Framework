<?php

namespace Runn\tests\Framework\CliApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Core\Std;
use Runn\Di\Container;
use Runn\Di\ContainerEntryNotFoundException;
use Runn\Di\ContainerInterface;
use Runn\Di\ContainerTrait;
use Runn\Framework\CliApplication;

class testContainerWithConstruct implements ContainerInterface {
    use ContainerTrait;
    public function __construct(Config $config) {
        foreach ($config as $key => $val) {
            echo $key . '=>' . $val;
        }
    }
}

class CliApplicationContainerTest extends TestCase
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
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => Container::class]]));

        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new Container(), $app->getContainer());
    }

    public function testContainerWithConstruct()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => testContainerWithConstruct::class]]));

        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new testContainerWithConstruct(new Config()), $app->getContainer());

        $this->expectOutputString('foo=>barbaz=>42foo=>barbaz=>42');
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => [
            'class' => testContainerWithConstruct::class,
            'foo' => 'bar',
            'baz' => 42
        ]]));
        $this->assertTrue($app->hasContainer());
        $this->assertEquals(new testContainerWithConstruct(new Config(['foo' => 'bar', 'baz' => 42])), $app->getContainer());
    }

    public function testContainerMagicNotFoundException()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => Container::class]]));

        $this->assertFalse(isset($app->service));

        $this->expectException(ContainerEntryNotFoundException::class);
        $app->service;
    }

    public function testContainerMagic()
    {
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config(['container' => ['class' => Container::class]]));

        $this->assertFalse(isset($app->service));

        $service = new Std(['foo' => 'bar']);
        $app->getContainer()->set('service', function () use ($service) { return $service; } );

        $this->assertTrue(isset($app->service));
        $this->assertSame($service, $app->service);
    }

}
