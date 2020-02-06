<?php

namespace Runn\Routing\Dto;

use Runn\ValueObjects\ValueObjectsCollection;

class Actions extends ValueObjectsCollection
{
    public static function getType()
    {
        return Action::class;
    }
}