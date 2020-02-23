<?php

namespace Runn\tests\Framework\WebApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Di\Container;
use Runn\Di\ContainerInterface;
use Runn\Di\ContainerTrait;
use Runn\Framework\ServiceProvider;
use Runn\Framework\WebApplication;

class testServiceProvider1 extends ServiceProvider {
    public function register(ContainerInterface $container)
    {
        $container->set('foo', function () {return 'bar';});
    }
}

class WebApplicationServiceProvidersTest extends TestCase
{

    protected function destroySingletonInstance(string $class)
    {
        $reflector = new \ReflectionProperty($class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null);
        $reflector->setAccessible(false);
    }

    public function testWithServiceProvider()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config([
            'container' => ['class' => Container::class],
            'providers' => [
                testServiceProvider1::class,
            ]
        ]));

        $this->assertSame($app, app());
        $this->assertTrue($app->getContainer()->has('foo'));
        $this->assertSame('bar', $app->getContainer()->get('foo'));
    }

}
