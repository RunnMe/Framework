<?php

namespace Runn\tests\Framework\Action;

use PHPUnit\Framework\TestCase;
use Runn\Framework\Action;
use Runn\Http\Request;
use Runn\Http\Response;
use Runn\Http\ResponseInterface;

class ActionTest extends TestCase
{

    public function testEmptyHandle()
    {
        $action = new class extends Action {
            protected function handle(): ?ResponseInterface {
                return null;
            }
        };

        $request = new Request();
        $response = new Response();

        $this->assertSame($response, $action($request, $response));
    }

    public function testRequestParam()
    {
        $action = new class extends Action {
            protected function handle(): ?ResponseInterface {
                $response = new Response();
                $response->getBody()->write('ID: ' . $this->request->getParam('id'));
                $response->getBody()->rewind();
                return $response;
            }
        };

        $request = new Request();
        $request->addRouteParam('id', 'foo');
        $response = new Response();

        $this->assertSame('ID: foo', $action($request, $response)->getBody()->getContents());
    }

    public function testRequestParamAsArg()
    {
        $action = new class extends Action {
            protected function handle($id = null): ?ResponseInterface {
                $response = new Response();
                $response->getBody()->write('ID: ' . $id);
                $response->getBody()->rewind();
                return $response;
            }
        };

        $request = new Request();
        $request->addRouteParam('id', 'foo');
        $response = new Response();

        $this->assertSame('ID: foo', $action($request, $response)->getBody()->getContents());
    }

}
