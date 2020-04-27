<?php

namespace Runn\Contracts\Environment;

use Runn\Fs\File;

/**
 * Interface EnvironmentInterface
 * @package Runn\Contracts\Environment
 */
interface EnvironmentInterface
{
    /**
     * Loads the environment file (.env for example)
     *
     * @param File $file
     * @return void
     */
    public function load(File $file): void ;

    /**
     * Returns the environment value
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

}
