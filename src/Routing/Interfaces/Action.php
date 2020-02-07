<?php

namespace Runn\Routing\Interfaces;

use Runn\Http\Request;
use Runn\Http\Response;

/**
 * Base action
 *
 * Interface Action
 * @package Runn\Routing\Interfaces
 */
interface Action
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response|null
     */
    public function __invoke(Request $request, Response $response): ?Response;
}