<?php

namespace Runn\tests\Framework\Actions;

use PHPUnit\Framework\TestCase;
use Runn\Core\Exception;
use Runn\Framework\ActionInterface;
use Runn\Framework\Actions;
use Runn\Http\Request;
use Runn\Http\Response;

class testAction implements ActionInterface {
    public function __invoke(Request $request, Response $response): ?Response
    {
        return (new Response())->withStatus(0);
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

}
