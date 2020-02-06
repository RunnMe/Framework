<?php

use Runn\Routing\Dto\Action;
use Runn\Routing\Dto\Actions;
use Runn\Routing\BarAction;
use Runn\Routing\FooAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$router = new \Runn\Routing\Router($request);

$router->addRoute(function (Request $request) {
    if ($request->getPathInfo() === '/blog') {
        return Actions::new([BarAction::class, FooAction::class]);
    }
});

$router->getResponseFromChainOfActions()->send();