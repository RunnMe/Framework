<?php

namespace Runn\Framework;

use Runn\Core\TypedCollection;
use Runn\Http\Request;
use Runn\Http\Response;

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
     * @param Request $request
     * @param Response $response
     * @return Response|null
     */
    public function __invoke(Request $request, Response $response): ?Response
    {
        if ($this->empty()) {
            return null;
        }
        foreach ($this as $actionClass) {
            /** @var ActionInterface $actionInstance */
            $actionInstance = new $actionClass;
            $response = $actionInstance($request, $response) ?? new Response();
        }
        return $response;
    }

}
