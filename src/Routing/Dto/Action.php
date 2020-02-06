<?php

namespace Runn\Routing\Dto;

use Runn\Routing\Dto\Validators\ActionValidator;
use Runn\Validation\Validator;
use Runn\ValueObjects\SingleValueObject;

class Action extends SingleValueObject
{
    protected function getDefaultValidator(): Validator
    {
        return new ActionValidator();
    }
}