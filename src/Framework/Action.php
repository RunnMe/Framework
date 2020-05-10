<?php

namespace Runn\Framework;

use Runn\Http\RequestInterface;
use Runn\Http\ResponseInterface;
use Runn\Reflection\ReflectionHelpers;

/**
 * Class Action
 * @package Runn\Framework
 */
abstract class Action implements ActionInterface
{

    /**
     * @var RequestInterface
     */
    protected /* @7.4 RequestInterface */$request;

    /**
     * @var ResponseInterface
     */
    protected /* @7.4 ResponseInterface */$response;

    /**
     * @return ResponseInterface|null
     */
    abstract protected function handle(): ?ResponseInterface;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface|null
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;

        $handleArgs = ReflectionHelpers::getObjectMethodArgs($this, 'handle');
        $args = [];
        foreach ($handleArgs as $name => $neededArg) {
            $args[] = $request->getParam($name) ?? $neededArg['default'];
        }
        $response = $this->handle(...$args);
        return $response ?? $this->response;
    }

}
