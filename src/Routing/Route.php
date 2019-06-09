<?php

namespace Runn\Routing;

use Runn\Http\Uri;

class Route implements RouteInterface
{

    protected const ALLOWED_HTTP_METHODS = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'];

    protected $method;

    /**
     * @param string $method
     * @return RouteInterface
     */
    public function setHttpMethod(string $method = null): RouteInterface
    {
        $this->method = in_array(strtoupper($method), self::ALLOWED_HTTP_METHODS) ? strtoupper($method): self::ALLOWED_HTTP_METHODS[0];
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string
    {
        return $this->method;
    }

    public function setUriTemplate(string $template): RouteInterface
    {
        // TODO: Implement setUriTemplate() method.
    }

    public function getUriTemplate(): string
    {
        // TODO: Implement getUriTemplate() method.
    }

    public function matches(string $method, Uri $uri): bool
    {
        // TODO: Implement matches() method.
    }

}
