<?php

namespace Runn\Framework\Cache\File;

use Runn\Framework\Cache\InvalidCacheKeyException;

/**
 * Default cache file name strategy, based on cache key 'sha256' hash
 *
 * Class DefaultFilenameStrategy
 * @package Runn\Framework\Cache\File\FileCache
 */
class DefaultFilenameStrategy implements FilenameStrategyInterface
{

    /**
     * @param string $key
     * @return string
     * @throws InvalidCacheKeyException
     */
    public function getFileNameByKey(string $key): string
    {
        if (empty($key)) {
            throw new InvalidCacheKeyException($key);
        }
        $hash = hash('sha256', $key);
        return substr($hash, 0, 2) . DIRECTORY_SEPARATOR . substr($hash, 2);
    }

}
