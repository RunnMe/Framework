<?php

namespace Runn\tests\Framework\ServiceProvider;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Di\Container;
use Runn\Di\ContainerInterface;
use Runn\Framework\Exception;
use Runn\Framework\ServiceProvider;
use Runn\Framework\WebApplication;

class testServiceProvider extends ServiceProvider {
    public function register(ContainerInterface $container)
    {
        $container->set('foo', static function () { return 'bar'; });
    }
}

class ServiceProviderTest extends TestCase
{

    protected function destroySingletonInstance(string $class)
    {
        $reflector = new \ReflectionProperty($class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null);
        $reflector->setAccessible(false);
    }

    public function testWithAppWithoutContainerWithoutProviders()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config([]));

        $this->assertSame($app, app());
        $this->assertFalse($app->hasContainer());
    }

    public function testWithAppWithoutContainerWithProviders()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config([]));

        $this->assertSame($app, app());
        $this->assertFalse($app->hasContainer());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Application has not container');
        $provider = new testServiceProvider();
    }

    public function testWithAppWithContainerWithProviders()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config([
            'container' => ['class' => Container::class],
            'providers' => [testServiceProvider::class]
        ]));

        $this->assertSame($app, app());
        $this->assertTrue($app->hasContainer());

        $this->assertSame('bar', $app->getContainer()->get('foo'));
    }

}
