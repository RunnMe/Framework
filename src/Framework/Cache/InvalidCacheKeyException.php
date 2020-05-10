<?php

namespace Runn\Framework\Cache;

class InvalidCacheKeyException extends \Runn\Framework\Exception implements \Runn\Contracts\Cache\InvalidArgumentException
{

    protected /* @7.4 string */$key;

    public function __construct(string $key, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->key = $key;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getKey(): string
    {
        return $this->key;
    }

}
