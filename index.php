<?php

use Runn\Routing\Actions;
use Runn\Routing\BarAction;
use Runn\Routing\FooAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$routes = [
    function (Request $request) {
        if ($request->getPathInfo() === '/blog') {
            return new Actions([BarAction::class, FooAction::class]);
        }
    },
    function (Request $request) {
        if ($request->getPathInfo() === '/bar') {
            return new Actions([BarAction::class]);
        }
    },
    function (Request $request) {
        if ($request->getPathInfo() === '/foo') {
            return new Actions([FooAction::class]);
        }
    }
];

$router = new \Runn\Routing\Router($routes);

$actions = $router->handle($request);

if (!empty($actions)) {
    $response = new Response();
    foreach ($actions as $action) {
        /** @var \Runn\Routing\Interfaces\Action $actionInstance */
        $actionInstance = new $action;
        $response = $actionInstance($request, $response);
    }
    $response->send();
} else {
    (new Response())->setStatusCode(404)->send();
}

