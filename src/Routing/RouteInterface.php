<?php

namespace Runn\Routing;

use Runn\Http\Uri;

/**
 * Interface for routes
 * Route is an object contains information about client request and this request handler
 *
 * Interface RouteInterface
 * @package Runn\Routing
 */
interface RouteInterface
{

    /**
     * @param string $method
     * @return RouteInterface
     */
    public function setHttpMethod(string $method = null): self;

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string;

    public function setUriTemplate(string $template): self;

    public function getUriTemplate(): string;

    public function matches(string $method, Uri $uri): bool;

}
