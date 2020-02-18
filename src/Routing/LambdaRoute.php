<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\Request;

/**
 * Default lambda-based route class
 *
 * Class Route
 * @package Runn\Routing
 */
class LambdaRoute implements RouteInterface
{

    /** @var \Closure */
    protected $lambda;

    /**
     * Route constructor.
     * @param \Closure $lambda
     */
    public function __construct(\Closure $lambda)
    {
        $this->lambda = $lambda;
    }

    /**
     * @param \Closure $lambda
     * @return RouteInterface
     */
    public static function createFromLambda(\Closure $lambda): RouteInterface
    {
        return new static($lambda);
    }

    /**
     * @param Request $request
     * @return Actions|null
     */
    public function __invoke(Request $request): ?Actions
    {
        return ($this->lambda)($request);
    }

}
