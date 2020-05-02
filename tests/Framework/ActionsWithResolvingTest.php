<?php

namespace Runn\tests\Framework\Actions;

use PHPUnit\Framework\TestCase;
use Runn\Core\Config;
use Runn\Di\Container;
use Runn\Framework\ActionInterface;
use Runn\Framework\Actions;
use Runn\Framework\WebApplication;
use Runn\Http\Request;
use Runn\Http\RequestInterface;
use Runn\Http\Response;
use Runn\Http\ResponseInterface;

class Foo {}

class testActionWithResolve1 implements ActionInterface {

    public $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        $response->getBody()->write('Foo: ' . get_class($this->foo));
        return $response;
    }
}

class ActionsWithResolvingTest extends TestCase
{

    protected function destroySingletonInstance(string $class)
    {
        $reflector = new \ReflectionProperty($class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null);
        $reflector->setAccessible(false);
    }

    protected function makeApp()
    {
        $this->destroySingletonInstance(WebApplication::class);
        $app = WebApplication::instance(new Config(['container' => ['class' => Container::class]]));
    }

    public function testWithResolving()
    {
        $this->makeApp();
        $actions = new Actions();
        $actions[] = testActionWithResolve1::class;

        $response = $actions->__invoke(new Request(), new Response());
        $response->getBody()->rewind();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('Foo: Runn\\tests\\Framework\\Actions\\Foo', $response->getBody()->getContents());
    }

}
