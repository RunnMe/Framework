<?php

namespace Runn\tests\Framework\WebApplication;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Framework\Actions;
use Runn\Framework\WebApplication;
use Runn\Http\Request;
use Runn\Http\RequestInterface;
use Runn\Routing\LambdaRoute;
use Runn\Routing\RouteInterface;
use Runn\Routing\Router;
use Runn\Routing\RouterInterface;
use Runn\Routing\Routes;

class testRouterWithConstruct implements RouterInterface {
    public function __construct(Config $config) {
        foreach ($config as $key => $val) {
            echo $key . '=>' . $val;
        }
    }
    public function addRoute(RouteInterface $route) {}
    public function addRoutes(iterable $routes) {}
    public function handle(RequestInterface $request): ?Actions {}
}

class WebApplicationRouterTest extends TestCase
{

    public function testDefaultRouter()
    {
        $app = WebApplication::instance(new Config(['router' => ['class' => Router::class]]));
        $this->assertTrue($app->hasRouter());
        $this->assertEquals(new Router(), $app->getRouter());
    }

    public function testRouterWithConstruct()
    {
        $app = WebApplication::instance(new Config(['router' => ['class' => testRouterWithConstruct::class]]));
        $this->assertTrue($app->hasRouter());
        $this->assertEquals(new testRouterWithConstruct(new Config()), $app->getRouter());

        $this->expectOutputString('foo=>barbaz=>42foo=>barbaz=>42');
        $app = WebApplication::instance(new Config(['router' => [
            'class' => testRouterWithConstruct::class,
            'foo' => 'bar',
            'baz' => 42
        ]]));
        $this->assertTrue($app->hasRouter());
        $this->assertEquals(new testRouterWithConstruct(new Config(['foo' => 'bar', 'baz' => 42])), $app->getRouter());
    }

    public function testRoterWithRoutes()
    {
        $routes = [
            new class implements RouteInterface {
                public function __invoke(RequestInterface $request): ?Actions {
                    return null;
                }
            },

            new LambdaRoute(function (Request $request): ?Actions {
                return null;
            }),
        ];

        $app = WebApplication::instance(new Config([
            'router' => [
                'class' => Router::class,
                'routes' => $routes
            ],
        ]));

        $this->assertTrue($app->hasRouter());

        $reflector = new \ReflectionProperty(Router::class, 'routes');
        $reflector->setAccessible(true);

        $this->assertInstanceOf(Routes::class, $reflector->getValue($app->getRouter()));
        $this->assertCount(2, $reflector->getValue($app->getRouter()));

        $this->assertSame($routes[0], $reflector->getValue($app->getRouter())[0]);
        $this->assertSame($routes[1], $reflector->getValue($app->getRouter())[1]);
    }

}
