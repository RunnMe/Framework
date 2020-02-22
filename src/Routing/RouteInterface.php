<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\RequestInterface;

/**
 * Base interface for routes: routing rules
 *
 * Interface RouteInterface
 * @package Runn\Routing
 */
interface RouteInterface
{

    /**
     * @param RequestInterface $request
     * @return Actions|null
     */
    public function __invoke(RequestInterface $request): ?Actions;

}
