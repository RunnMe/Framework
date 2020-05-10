<?php

namespace Runn\Framework;

use Runn\Di\ContainerInterface;

/**
 * Abstract service provider class
 *
 * Class ServiceProvider
 * @package Runn\Framework
 */
abstract class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var WebApplication
     * @todo 7.4 type hint
     */
    protected $app;

    /**
     * ServiceProvider constructor.
     */
    public function __construct()
    {
        $this->app = app();
        if (!$this->app->hasContainer()) {
            throw new Exception('Application has not container');
        }
        $this->register($this->app->getContainer());
    }

    abstract public function register(ContainerInterface $container);

}
