<?php

namespace Runn\Routing;

use Runn\Framework\Actions;
use Runn\Http\RequestInterface;

/**
 * Default lambda-based route class
 *
 * Class Route
 * @package Runn\Routing
 */
class LambdaRoute implements RouteInterface
{

    /** @var \Closure */
    protected \Closure $lambda;

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
     * @param RequestInterface $request
     * @return Actions|null
     */
    public function __invoke(RequestInterface $request): ?Actions
    {
        return ($this->lambda)($request);
    }

}
