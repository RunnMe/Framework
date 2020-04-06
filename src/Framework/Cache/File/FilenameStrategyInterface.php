<?php

namespace Runn\Framework\Cache\File;

use Runn\Framework\Cache\InvalidCacheKeyException;

/**
 * Interface FilenameStrategyInterface
 * @package Runn\Framework\Cache\File\FileCache
 */
interface FilenameStrategyInterface
{

    /**
     * @param string $key
     * @return string
     * @throws InvalidCacheKeyException
     */
    public function getFileNameByKey(string $key): string;

}
