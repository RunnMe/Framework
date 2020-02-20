<?php

namespace Runn\Framework;

/**
 * Common container interface
 *
 * Interface ContainerInterface
 * @package Runn\Framework
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{

    /**
     * Stores entry by its identifier
     *
     * @param string $id
     * @param mixed $entry
     * @param bool $singleton
     * @return object
     */
    public function set(string $id, $entry, bool $singleton = false);

}
