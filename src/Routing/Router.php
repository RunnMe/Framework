<?php

namespace Runn\Routing;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    protected array $routes;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

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