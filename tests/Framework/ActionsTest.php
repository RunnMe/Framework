<?php

namespace Runn\tests\Framework\Actions;

use PHPUnit\Framework\TestCase;
use Runn\Core\Exception;
use Runn\Framework\ActionInterface;
use Runn\Framework\Actions;
use Runn\Http\Request;
use Runn\Http\RequestInterface;
use Runn\Http\Response;
use Runn\Http\ResponseInterface;

class testActionReturnsNull implements ActionInterface {
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        return null;
    }
}

class testAction implements ActionInterface {
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        return (new Response())->withStatus(201);
    }
}

class ActionsTest extends TestCase
{

    public function testValidMember()
    {
        $actions = new Actions();
        $actions[] = testAction::class;

        $this->assertCount(1, $actions);
        $this->assertSame(testAction::class, $actions[0]);
    }

    public function testInvalidNotStringMember()
    {
        $actions = new Actions();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Typed collection type mismatch');
        $actions[] = new \stdClass();
    }

    public function testInvalidNotActionStringMember()
    {
        $actions = new Actions();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Typed collection type mismatch');
        $actions[] = 'foo';
    }

    public function testInvokeEmpty()
    {
        $actions = new Actions();

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $this->assertNull($actions($request, new Response()));
    }

    public function testOneActionReturnsNull()
    {
        $actions = new Actions([testActionReturnsNull::class]);

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $responce = $actions($request, new Response());
        $this->assertInstanceOf(Response::class, $responce);
        $this->assertEquals(200, $responce->getStatusCode());
    }

    public function testOneAction()
    {
        $actions = new Actions([testAction::class]);

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $responce = $actions($request, new Response());
        $this->assertInstanceOf(Response::class, $responce);
        $this->assertEquals(201, $responce->getStatusCode());
    }

    public function testActionsChainReturnsNull()
    {
        $actions = new Actions([testAction::class, testActionReturnsNull::class]);

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $responce = $actions($request, new Response());
        $this->assertInstanceOf(Response::class, $responce);
        $this->assertEquals(200, $responce->getStatusCode());
    }

    public function testActionsChain()
    {
        $actions = new Actions([testActionReturnsNull::class, testAction::class]);

        $reflector = new \ReflectionClass(Request::class);
        $request = $reflector->newInstanceWithoutConstructor();

        $responce = $actions($request, new Response());
        $this->assertInstanceOf(Response::class, $responce);
        $this->assertEquals(201, $responce->getStatusCode());
    }

}
