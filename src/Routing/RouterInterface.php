<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\RequestInterface;

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
     * @return $this
     */
    public function addRoute(RouteInterface $route);

    /**
     * Adds routes to routes chain
     *
     * @param iterable $routes
     * @return $this
     */
    public function addRoutes(iterable $routes);

    /**
     * Handle incoming request
     *
     * @param RequestInterface $request
     * @return Actions|null
     */
    public function handle(RequestInterface $request): ?Actions;

}
