<?php

namespace Runn\Framework;

use Runn\Core\TypedCollection;
use Runn\Http\RequestInterface;
use Runn\Http\Response;
use Runn\Http\ResponseInterface;

/**
 * Typed collection of action classes
 *
 * Class Actions
 * @package Runn\Routing
 */
class Actions extends TypedCollection implements ActionInterface
{

    public static function getType()
    {
        return 'string';
    }

    /**
     * @param mixed $value
     * @param bool $strict
     * @return bool
     */
    protected function isValueTypeValid($value, $strict = false): bool
    {
        if(!parent::isValueTypeValid($value, $strict)) {
            return false;
        }

        return is_subclass_of($value, ActionInterface::class);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface|null
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        if ($this->empty()) {
            return null;
        }
        foreach ($this as $actionClass) {
            /** @var ActionInterface $actionInstance */
            if (function_exists('app') && app()->hasContainer()) {
                $actionInstance = app()->getContainer()->resolve($actionClass);
            } else {
                $actionInstance = new $actionClass;
            }
            $response = $actionInstance($request, $response) ?? new Response();
        }
        return $response;
    }

}
