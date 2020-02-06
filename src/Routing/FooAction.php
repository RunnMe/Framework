<?php

namespace Runn\Routing;

use Runn\Contracts\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FooAction implements Action
{
    public function __invoke(Request $request, Response $response): ?Response
    {
        return $response->setStatusCode(201);
    }
}