<?php

namespace Runn\Framework\Cache;

class InvalidCacheKeyException extends \Runn\Framework\Exception implements \Runn\Contracts\Cache\InvalidArgumentException
{

    protected $key;

    public function __construct($key, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->key = $key;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

}