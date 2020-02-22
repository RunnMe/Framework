<?php

namespace Runn\Framework;

use Runn\Core\Config;
use Runn\Core\ConfigAwareInterface;
use Runn\Core\ConfigAwareTrait;
use Runn\Core\InstanceableByConfigInterface;
use Runn\Di\ContainerInterface;
use Runn\Routing\RouterInterface;

/**
 * Default web-application class
 *
 * Class WebApplication
 * @package Runn\Framework
 */
class WebApplication implements ConfigAwareInterface, InstanceableByConfigInterface
{

    use ConfigAwareTrait;

    /** @var ContainerInterface */
    protected $container;

    /** @var RouterInterface */
    protected $router;

    /**
     * @param \Runn\Core\Config|null $config
     * @return static
     * @throws Exception
     */
    public static function instance(Config $config = null)
    {
        return new static($config ?? new Config());
    }

    /**
     * WebApplication constructor.
     *
     * @param Config $config
     * @throws Exception
     */
    protected function __construct(Config $config)
    {
        $this->setConfig($config);
        $this->init();
    }

    /**
     * Prior services initialization
     *
     * @throws Exception
     */
    protected function init()
    {
        if ( !empty($this->config->container) && !empty($this->config->container->class) ) {
            if ( !is_subclass_of($this->config->container->class, ContainerInterface::class) ) {
                throw new Exception('Invalid container class: ' . $this->config->container->class);
            }
            $this->container = $this->initContainer($this->config->container);
        }

        if ( !empty($this->config->router) && !empty($this->config->router->class) ) {
            if ( !is_subclass_of($this->config->router->class, RouterInterface::class) ) {
                throw new Exception('Invalid router class: ' . $this->config->router->class);
            }
            $this->router = $this->initRouter($this->config->router);
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
     * Router initialization
     *
     * @param Config $config
     * @return RouterInterface
     */
    protected function initRouter(Config $config): RouterInterface
    {
        $config = clone $config;
        $class = $config->class;
        $routes = $config->routes ?? [];
        unset($config->class);
        unset($config->routes);

        /** @var RouterInterface $router */
        $router = new $class($config);
        if (!empty($routes) && is_iterable($routes)) {
            $router->addRoutes($routes);
        }
        return $router;
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
     * @return bool
     */
    public function hasRouter(): bool
    {
        return !empty($this->router);
    }

    /**
     * @return RouterInterface|null
     */
    public function getRouter(): ?RouterInterface
    {
        return $this->hasRouter() ? $this->router : null;
    }

}
