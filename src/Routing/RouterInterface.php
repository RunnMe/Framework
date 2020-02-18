<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\Request;

/**
 * Base interface for routers
 *
 * Interface RouterInterface
 * @package Runn\Routing
 */
interface RouterInterface
{

    /**
     * Adds route to routes chain
     *
     * @param RouteInterface $route
     * @return mixed
     */
    public function addRoute(RouteInterface $route);

    /**
     * Handle incoming request
     *
     * @param Request $request
     * @return Actions|null
     */
    public function handle(Request $request): ?Actions;

}
