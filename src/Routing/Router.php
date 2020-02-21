<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\Request;

/**
 * Default router for dispatch chain of actions by request
 *
 * Class Router
 * @package Runn\Routing
 */
class Router implements RouterInterface
{

    /** @var Routes $routes */
    protected $routes;

    /**
     * Router constructor.
     *
     * @param iterable $routes Routes collection
     */
    public function __construct(iterable $routes = [])
    {
        $this->routes = new Routes();
        $this->addRoutes($routes);
    }

    /**
     * Adds route to routes chain
     *
     * @param RouteInterface $route
     * @return $this
     */
    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
        return $this;
    }

    /**
     * Adds routes to routes chain
     *
     * @param iterable $routes
     * @return $this
     */
    public function addRoutes(iterable $routes)
    {
        foreach ($routes as $route) {
            switch (true) {
                case $route instanceof RouteInterface:
                    $this->addRoute($route);
                    break;
                case $route instanceof \Closure:
                    $this->addRoute(LambdaRoute::createFromLambda($route));
                    break;
            }
        }
        return $this;
    }

    /**
     * Handle incoming request
     *
     * @param Request $request
     * @return Actions|null
     */
    public function handle(Request $request): ?Actions
    {
        foreach ($this->routes as $route) {
            $actions = $route($request);
            if (!empty($actions)) {
                return $actions;
            }
        }
        return null;
    }

}
