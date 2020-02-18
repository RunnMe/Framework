<?php

namespace Runn\Routing;

use Runn\Core\TypedCollection;

/**
 * Typed collection of routes
 *
 * Class Routes
 * @package Runn\Routing
 */
class Routes extends TypedCollection
{

    public static function getType()
    {
        return RouteInterface::class;
    }

}
