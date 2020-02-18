<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\Request;

/**
 * Base interface for routes: routing rules
 *
 * Interface RouteInterface
 * @package Runn\Routing
 */
interface RouteInterface
{

    /**
     * @param Request $request
     * @return Actions|null
     */
    public function __invoke(Request $request): ?Actions;

}
