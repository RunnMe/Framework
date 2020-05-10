<?php

namespace Runn\Framework;

use Runn\Core\Config;
use Runn\Core\ConfigAwareInterface;
use Runn\Core\ConfigAwareTrait;
use Runn\Core\InstanceableByConfigInterface;
use Runn\Core\SingletonInterface;
use Runn\Core\SingletonTrait;
use Runn\Di\ContainerInterface;

/**
 * Default command line application class
 *
 * Class CliApplication
 * @package Runn\Framework
 */
class CliApplication implements ConfigAwareInterface, SingletonInterface, InstanceableByConfigInterface
{

    use ConfigAwareTrait;
    use SingletonTrait;

    /** @var static */
    protected static $instance = null;

    /** @var ContainerInterface */
    protected ContainerInterface $container;

    /**
     * CliApplication constructor.
     *
     * @param Config $config
     * @throws Exception
     */
    protected function __construct(Config $config)
    {
        $this->setConfig($config);

        if ( !empty($this->config->container) && !empty($this->config->container->class) ) {
            if ( !is_subclass_of($this->config->container->class, ContainerInterface::class) ) {
                throw new Exception('Invalid container class: ' . $this->config->container->class);
            }
            $this->container = $this->initContainer($this->config->container);
        }

        static::$instance = $this;
        if (!function_exists( 'app')) {
            eval("function app() {return \\" . get_called_class() . "::instance(); }");
        }

        $this->init();
    }

    /**
     * @param \Runn\Core\Config|null $config
     * @return static
     * @throws Exception
     */
    public static function instance(Config $config = null)
    {
        if (null === static::$instance) {
            static::$instance = new static($config ?? new Config());
        }
        return static::$instance;
    }

    /**
     * Prior services initialization
     *
     * @throws Exception
     */
    protected function init()
    {
        if ($this->hasContainer() && !empty($this->config->providers)) {
            $this->initProviders($this->config->providers);
        }
    }

    /**
     * Services container initialization
     *
     * @param Config $config
     * @return ContainerInterface
     */
    protected function initContainer(Config $config): ContainerInterface
    {
        $config = clone $config;
        $class = $config->class;
        unset($config->class);

        return new $class($config);
    }

    /**
     * Service providers initialization
     *
     * @param Config $config
     */
    protected function initProviders(Config $config): void
    {
        foreach ($config as $class) {
            if (is_string($class) && is_subclass_of($class, ServiceProvider::class)) {
                $provider = new $class;
                $provider->register($this->getContainer());
            }
        }
    }

    /**
     * @return bool
     */
    public function hasContainer(): bool
    {
        return !empty($this->container);
    }

    /**
     * @return ContainerInterface|null
     */
    public function getContainer(): ?ContainerInterface
    {
        return $this->hasContainer() ? $this->container : null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        if (!$this->hasContainer()) {
            return false;
        }
        return $this->getContainer()->has($name);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!$this->hasContainer()) {
            return null;
        }
        return $this->getContainer()->resolve($name);
    }

}
