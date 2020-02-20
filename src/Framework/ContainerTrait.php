<?php

namespace Runn\Framework;

use Psr\Container\ContainerExceptionInterface;

/**
 * Default ContainerInterface implementation
 *
 * Trait ContainerTrait
 * @package Runn\Framework
 * @impelements ContainerInterface
 */
trait ContainerTrait /*implements ContainerTrait*/
{

    protected $entries = [];

    /**
     * Stores entry by its identifier
     *
     * @param string $id Identifier of the entry
     * @param mixed $entry Entry: lambda function, object or class name
     * @param bool $singleton
     * @return $this
     *
     * @throws ContainerException
     */
    public function set(string $id, $entry, bool $singleton = false)
    {
        if (is_object($entry) && ($entry instanceof \Closure)) {
            $this->setLambda($id, $entry, $singleton);
            return $this;
        }
        if (is_object($entry) && !($entry instanceof \Closure)) {
            $this->setObject($id, $entry, $singleton);
            return $this;
        }
        if (is_string($entry) && class_exists($entry)) {
            $this->setClass($id, $entry, $singleton);
            return $this;
        }
        throw new ContainerException('Invalid entry');
    }

    /**
     * Stores entry by its identifier as singleton
     *
     * @param string $id Identifier of the entry
     * @param mixed $entry Entry: lambda function, object or class name
     * @return $this
     * @throws ContainerException
     */
    public function singleton(string $id, $entry)
    {
        $this->set($id, $entry, true);
        return $this;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws ContainerNotFoundException  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ContainerNotFoundException($id);
        }
        $record = &$this->entries[$id];
        if ($record['singleton']) {
            if (!$record['used']) {
                $record['entry'] = $record['entry']();
                $record['used'] = true;
            }
            return $record['entry'];
        }
        return $this->entries[$id]['entry']();
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has($id)
    {
        return isset($this->entries[$id]);
    }

    /**
     * Stores a lambda function as entry instantiator
     *
     * @param string $id
     * @param callable $entry
     * @param bool $singleton
     */
    protected function setLambda(string $id, callable $entry, bool $singleton)
    {
        $this->entries[$id] = ['singleton' => $singleton, 'used' => false, 'entry' => $entry];
    }

    /**
     * Stores an object as entry
     *
     * @param string $id
     * @param object $entry
     * @param bool $singleton
     */
    protected function setObject(string $id, object $entry, bool $singleton)
    {
        $this->entries[$id] = ['singleton' => $singleton, 'used' => false, 'entry' => function () use ($entry) {return $entry;}];
    }

    /**
     * Stores a class name as entry
     *
     * @param string $id
     * @param string $entry
     * @param bool $singleton
     */
    protected function setClass(string $id, string $entry, bool $singleton)
    {
        $this->entries[$id] = ['singleton' => $singleton, 'used' => false, 'entry' => function () use ($entry) {return new $entry;}];
    }

}
