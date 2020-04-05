<?php

namespace Runn\Contracts\Cache;

/**
 * Interface InvalidArgumentException
 * @package Runn\Contracts\Cache
 */
interface InvalidArgumentException extends CacheException
{

    /**
     * @return mixed
     */
    public function getArgumentValue();

}
