<?php

namespace Runn\Routing;

use Runn\Http\Request;

/**
 * Router for dispatch sequence of actions by request
 *
 * Class Router
 * @package Runn\Routing
 */
class Router
{
    /** @var callable[] $routes */
    protected array $routes;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
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