<?php

namespace Runn\Routing;

use Runn\Contracts\Action;
use Runn\Routing\Dto\Actions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private Request $request;

    protected array $routes;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addRoute(callable $route): self
    {
        $this->routes[] = $route;
        return $this;
    }

    public function getResponseFromChainOfActions(): Response
    {
        $response = new Response();
        /** @var \Closure $route */
        foreach ($this->routes as $route) {

            /** @var Actions $actions */
            $actions = $route($this->request);

            foreach ($actions as $action) {
                $actionClass = (string)$action;
                $actionInstance = new $actionClass;
                $response = $actionInstance($this->request, $response);
            }
        }

        return $response;
    }
}