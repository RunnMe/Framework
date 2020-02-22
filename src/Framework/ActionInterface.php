<?php

namespace Runn\Framework;

use Runn\Http\RequestInterface;
use Runn\Http\ResponseInterface;

/**
 * Common framework action interface
 *
 * Interface ActionInterface
 * @package Runn\Framework
 */
interface ActionInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface|null
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface;

}
