<?php

namespace Runn\Routing;

use Runn\Routing\Interfaces\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Foo1Action implements Action
{
    public function __invoke(Request $request, Response $response): Response
    {
        return new JsonResponse(['3' => '3']);
    }
}