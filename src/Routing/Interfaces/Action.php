<?php

namespace Runn\Routing\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface Action
{
    public function __invoke(Request $request, Response $response): ?Response;
}