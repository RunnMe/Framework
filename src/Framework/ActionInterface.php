<?php

namespace Runn\Framework;

use Runn\Http\Request;
use Runn\Http\Response;

/**
 * Common framework action interface
 *
 * Interface ActionInterface
 * @package Runn\Framework
 */
interface ActionInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response|null
     */
    public function __invoke(Request $request, Response $response): ?Response;

}
