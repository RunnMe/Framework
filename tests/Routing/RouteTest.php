<?php

namespace Runn\tests\Framework\Routing\Route;

use PHPUnit\Framework\TestCase;
use Runn\Html\Form\Fields\BooleanField;
use Runn\Html\Form\Fields\NumberField;
use Runn\Html\ValidationError;
use Runn\Routing\Route;

class RouteTest extends TestCase
{

    public function testSetGetMethod()
    {
        $route = new Route;

        $this->assertNull($route->getHttpMethod());

        $route->setHttpMethod();
        $this->assertSame('GET', $route->getHttpMethod());

        $route->setHttpMethod('');
        $this->assertSame('GET', $route->getHttpMethod());

        $route->setHttpMethod('GET');
        $this->assertSame('GET', $route->getHttpMethod());

        $route->setHttpMethod('post');
        $this->assertSame('POST', $route->getHttpMethod());

        $route->setHttpMethod('foo');
        $this->assertSame('GET', $route->getHttpMethod());
    }

}
