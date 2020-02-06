<?php

namespace Runn\Routing\Dto\Validators;

use Runn\Contracts\Action;
use Runn\Routing\Dto\Exceptions\InvalidAction;
use Runn\Validation\Validator;

class ActionValidator extends Validator
{
    /**
     * @param mixed $value
     * @return bool
     * @throws InvalidAction
     */
    public function validate($value): bool
    {
        if (is_subclass_of($value, Action::class)) {
            return true;
        }

        throw new InvalidAction($value);
    }
}