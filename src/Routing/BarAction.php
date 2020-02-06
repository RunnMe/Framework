<?php

namespace Runn\Routing;

use Runn\Routing\Interfaces\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BarAction implements Action
{
    public function __invoke(Request $request, Response $response): Response
    {
        return new JsonResponse(['object' => 'value']);
    }
}