<?php

namespace Runn\tests\Routing\LambdaRoute;

use PHPUnit\Framework\TestCase;
use Runn\Framework\Actions;
use Runn\Http\Request;
use Runn\Http\RequestInterface;
use Runn\Routing\LambdaRoute;

class LambdaRouteTest extends TestCase
{

    public function testConstruct()
    {
        $reflector = new \ReflectionProperty(LambdaRoute::class, 'lambda');
        $reflector->setAccessible(true);

        $lambda = function (RequestInterface $request) {
            return new Actions([]);
        };
        $route = new LambdaRoute($lambda);
        $this->assertSame($lambda, $reflector->getValue($route));
    }

    public function testCreateFromLambda()
    {
        $reflector = new \ReflectionProperty(LambdaRoute::class, 'lambda');
        $reflector->setAccessible(true);

        $lambda = function (RequestInterface $request) {
            return new Actions([]);
        };
        $route = LambdaRoute::createFromLambda($lambda);
        $this->assertSame($lambda, $reflector->getValue($route));
        $this->assertEquals(new LambdaRoute($lambda), $route);
    }

    public function testInvoke()
    {
        $lambda = function (RequestInterface $request) {
            return new Actions([]);
        };
        $router = new LambdaRoute($lambda);

        $this->assertEquals(new Actions([]), $router(new Request()));
    }

}