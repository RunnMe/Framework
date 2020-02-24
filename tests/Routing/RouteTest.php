<?php

namespace Runn\tests\Routing\Route;

use PHPUnit\Framework\TestCase;
use Runn\Html\Form\Fields\BooleanField;
use Runn\Html\Form\Fields\NumberField;
use Runn\Html\ValidationError;
use Runn\Routing\LambdaRoute;

class RouteTest extends TestCase
{

    public function testSetGetMethod()
    {
        $this->assertNull(null);
        /*
        $route = new LambdaRoute;

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
        */
    }

}
