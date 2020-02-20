<?php

namespace Runn\tests\Framework\ContainerTrait;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Runn\Core\Std;
use Runn\Framework\ContainerException;
use Runn\Framework\ContainerInterface;
use Runn\Framework\ContainerNotFoundException;
use Runn\Framework\ContainerTrait;

class ContainerTraitTest extends TestCase
{

    public function testSingletonMethod()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
            public function set(string $id, $entry, bool $singleton = false)
            {
                echo $id . '#' . $entry . '#' . ($singleton ? '1' : 0);
            }
        };

        $this->expectOutputString('foo#bar#1');
        $container->singleton('foo', 'bar');
    }

    public function testInvalidEntry()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
        };

        try {
            $container->set('foo', [1, 2, 3]);
        } catch (ContainerException $e) {
            $this->assertInstanceOf(ContainerExceptionInterface::class, $e);
            return;
        }

        $this->fail();
    }

    public function testNotFoundException()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
        };

        try {
            $container->get('foo');
        } catch (ContainerNotFoundException $e) {
            $this->assertInstanceOf(ContainerException::class, $e);
            $this->assertInstanceOf(ContainerExceptionInterface::class, $e);
            $this->assertInstanceOf(NotFoundExceptionInterface::class, $e);
            $this->assertSame('foo', $e->getId());
            return;
        }

        $this->fail();
    }

    public function testLambda()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
        };

        $entry = function () {
            return new Std(['foo' => 'bar']);
        };

        $this->assertFalse($container->has('test'));
        $ret = $container->set('test', $entry);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertNotSame($ret2, $ret1);

        $ret = $container->set('test', $entry, true);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertSame($ret2, $ret1);
    }

    public function testObject()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
        };

        $entry = new Std(['foo' => 'bar']);

        $this->assertFalse($container->has('test'));
        $ret = $container->set('test', $entry);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertSame($entry, $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertSame($entry, $ret2);
        $this->assertSame($ret1, $ret2);

        $ret = $container->set('test', $entry, true);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertSame($entry, $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std(['foo' => 'bar']), $ret1);
        $this->assertSame($entry, $ret2);
        $this->assertSame($ret1, $ret2);
    }

    public function testClass()
    {
        $container = new class implements ContainerInterface {
            use ContainerTrait;
        };

        $entry = Std::class;

        $this->assertFalse($container->has('test'));
        $ret = $container->set('test', $entry);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std, $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std, $ret1);
        $this->assertNotSame($ret1, $ret2);

        $ret = $container->set('test', $entry, true);
        $this->assertTrue($container->has('test'));
        $this->assertSame($container, $ret);

        $ret1 = $container->get('test');
        $this->assertEquals(new Std, $ret1);

        $ret2 = $container->get('test');
        $this->assertEquals(new Std, $ret1);
        $this->assertSame($ret1, $ret2);
    }

}
