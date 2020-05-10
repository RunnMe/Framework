<?php

namespace Runn\tests\Framework\CliApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Di\Container;
use Runn\Di\ContainerInterface;
use Runn\Framework\CliApplication;
use Runn\Framework\ServiceProvider;

class testServiceProvider1 extends ServiceProvider {
    public function register(ContainerInterface $container)
    {
        $container->set('foo', static function () {return 'bar';});
    }
}

class CliApplicationServiceProvidersTest extends TestCase
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
        $this->destroySingletonInstance(CliApplication::class);
        $app = CliApplication::instance(new Config([
            'container' => ['class' => Container::class],
            'providers' => [
                testServiceProvider1::class,
            ]
        ]));

        // @todo
        //$this->assertSame($app, app());
        $this->assertTrue($app->getContainer()->has('foo'));
        $this->assertSame('bar', $app->getContainer()->get('foo'));
    }

}
