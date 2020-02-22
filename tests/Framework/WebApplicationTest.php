<?php

namespace Runn\tests\Framework\WebApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Framework\Exception;
use Runn\Framework\WebApplication;


class WebApplicationTest extends TestCase
{

    public function testEmptyConfig()
    {
        $app = WebApplication::instance();
        $this->assertEquals(new Config(), $app->getConfig());
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
    }

    public function testWithoutContainer()
    {
        $app = WebApplication::instance(new Config());
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());

        $app = WebApplication::instance(new Config(['container' => 'foo']));
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());

        $app = WebApplication::instance(new Config(['container' => ['class' => '']]));
        $this->assertFalse($app->hasContainer());
        $this->assertNull($app->getContainer());
    }

    public function testInvalidContainer()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid container class: ' . \stdClass::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => \stdClass::class]]));
    }

    public function testWithoutRouter()
    {
        $app = WebApplication::instance(new Config());
        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());

        $app = WebApplication::instance(new Config(['router' => 'foo']));
        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());

        $app = WebApplication::instance(new Config(['router' => ['class' => '']]));
        $this->assertFalse($app->hasRouter());
        $this->assertNull($app->getRouter());
    }

    public function testInvalidRouter()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid router class: ' . \stdClass::class);
        $app = WebApplication::instance(new Config(['router' => ['class' => \stdClass::class]]));
    }

}
