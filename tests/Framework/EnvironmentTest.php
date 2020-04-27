<?php

namespace Runn\tests\Framework\Environment;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Framework\Environment;
use Runn\Framework\Exception;
use Runn\Framework\WebApplication;
use Runn\Fs\File;
use function Runn\env;

class EnvironmentTest extends TestCase
{

    public function testWithoutLoad()
    {
        $env = new Environment();
        $this->assertNull($env->get('foo'));
    }

    public function testLoad()
    {
        unset($_ENV);
        $env = new Environment();
        $this->assertNull($env->get('foo'));

        $env->load(new File(__DIR__ . '/test.env'));

        $this->assertSame('bar', $env->get('foo'));

        $this->assertSame(true,     $env->get('test11'));
        $this->assertSame(true,     $env->get('test12'));
        $this->assertSame(false,    $env->get('test21'));
        $this->assertSame(false,    $env->get('test22'));
        $this->assertSame('',       $env->get('test31'));
        $this->assertSame('',       $env->get('test32'));
        $this->assertSame(null,     $env->get('test41'));
        $this->assertSame(null,     $env->get('test42'));
    }

    public function testDefault()
    {
        unset($_ENV);
        $env = new Environment();
        $this->assertNull($env->get('foo'));
        $this->assertSame('bar', $env->get('foo', 'bar'));
        $this->assertSame('bar', $env->get('foo', function () {return 'bar';}));
    }

    public function testAsFunction()
    {
        unset($_ENV);
        $this->assertNull(env('foo'));
        $this->assertSame('bar', env('foo', 'bar'));

        $env = new Environment();
        $env->load(new File(__DIR__ . '/test.env'));

        $this->assertSame('bar', env('foo'));
    }

}
