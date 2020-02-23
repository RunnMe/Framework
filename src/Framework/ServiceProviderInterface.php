<?php

namespace Runn\Framework;

use Runn\Di\ContainerInterface;

/**
 * Common interface for all service providers
 *
 * Interface ServiceProviderInterface
 * @package Runn\Framework
 */
interface ServiceProviderInterface
{

    public function register(ContainerInterface $container);

}
