<?php

namespace Runn\tests\Routing\Router;

use PHPUnit\Framework\TestCase;
use Runn\Framework\ActionInterface;
use Runn\Framework\Actions;
use Runn\Http\Request;
use Runn\Http\Response;
use Runn\Routing\LambdaRoute;
use Runn\Routing\RouteInterface;
use Runn\Routing\Router;
use Runn\Routing\Routes;

class testAction1 implements ActionInterface {
    public function __invoke(Request $request, Response $response): ?Response
    {
        return (new Response())->withStatus(1);
    }
}

class testAction2 implements ActionInterface {
    public function __invoke(Request $request, Response $response): ?Response
    {
        return (new Response())->withStatus(2);
    }
}

class testAction3 implements ActionInterface {
    public function __invoke(Request $request, Response $response): ?Response
    {
        return (new Response())->withStatus(3);
    }
}

class RouterTest extends TestCase
{

    public function testEmptyConstructor()
    {
        $reflector = new \ReflectionProperty(Router::class, 'routes');
        $reflector->setAccessible(true);

        $router = new Router();

        $this->assertInstanceOf(Routes::class, $reflector->getValue($router));
        $this->assertCount(0, $reflector->getValue($router));
    }

    public function testConstructor()
    {
        $reflector = new \ReflectionProperty(Router::class, 'routes');
        $reflector->setAccessible(true);

        $routes = [

            new class implements RouteInterface {
                public function __invoke(Request $request): ?Actions {
                    return null;
                }
            },

            new LambdaRoute(function (Request $request): ?Actions {
                return null;
            }),

            function (Request $request): ?Actions {
                return null;
            }

        ];

        $router = new Router($routes);

        $this->assertInstanceOf(Routes::class, $reflector->getValue($router));
        $this->assertCount(3, $reflector->getValue($router));

        $this->assertSame($routes[0], $reflector->getValue($router)[0]);
        $this->assertSame($routes[1], $reflector->getValue($router)[1]);

        $this->assertInstanceOf(LambdaRoute::class, $reflector->getValue($router)[2]);
    }

    public function testAddRoute()
    {
        $reflector = new \ReflectionProperty(Router::class, 'routes');
        $reflector->setAccessible(true);

        $router = new Router();

        $this->assertInstanceOf(Routes::class, $reflector->getValue($router));
        $this->assertCount(0, $reflector->getValue($router));

        $route =
            new class implements RouteInterface {
                public function __invoke(Request $request): ?Actions {
                    return null;
                }
            };
        $result = $router->addRoute($route);

        $this->assertSame($router, $result);
        $this->assertInstanceOf(Routes::class, $reflector->getValue($router));
        $this->assertCount(1, $reflector->getValue($router));
        $this->assertSame($route, $reflector->getValue($router)[0]);
    }

    public function testAddRoutes()
    {
        $reflector = new \ReflectionProperty(Router::class, 'routes');
        $reflector->setAccessible(true);

        $routes = [

            new class implements RouteInterface {
                public function __invoke(Request $request): ?Actions {
                    return null;
                }
            },

            new LambdaRoute(function (Request $request): ?Actions {
                return null;
            }),

            function (Request $request): ?Actions {
                return null;
            }

        ];

        $router = new Router();
        $result = $router->addRoutes($routes);

        $this->assertSame($router, $result);
        $this->assertInstanceOf(Routes::class, $reflector->getValue($router));
        $this->assertCount(3, $reflector->getValue($router));

        $this->assertSame($routes[0], $reflector->getValue($router)[0]);
        $this->assertSame($routes[1], $reflector->getValue($router)[1]);

        $this->assertInstanceOf(LambdaRoute::class, $reflector->getValue($router)[2]);
    }

    public function testHandle()
    {
        $router = new Router([
            function (Request $request): ?Actions {
                return ($request->getMethod() == 'GET') ? new Actions([testAction1::class]) : null;
            },
            function (Request $request): ?Actions {
                return ($request->getMethod() == 'POST') ?  new Actions([testAction2::class, testAction3::class]) : null;
            }
        ]);

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $reflector = new \ReflectionProperty(Request::class, 'method');
        $reflector->setAccessible(true);

        $reflector->setValue($request, 'GET');
        $actions = $router->handle($request);
        $this->assertEquals(new Actions([testAction1::class]), $actions);

        $reflector->setValue($request, 'POST');
        $actions = $router->handle($request);
        $this->assertEquals(new Actions([testAction2::class, testAction3::class]), $actions);

        $reflector->setValue($request, 'OPTIONS');
        $actions = $router->handle($request);
        $this->assertNull($actions);
    }

}
