<?php

namespace Runn\Routing;

use Runn\Core\TypedCollection;
use Runn\Routing\Interfaces\ActionInterface;

/**
 * Typed collection of actions
 *
 * Class Actions
 * @package Runn\Routing
 */
class Actions extends TypedCollection
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
}
