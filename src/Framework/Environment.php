<?php

namespace Runn\Framework;

use Runn\Contracts\Environment\EnvironmentInterface;
use Runn\Fs\File;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Class Environment
 * @package Runn\Framework
 */
class Environment implements EnvironmentInterface
{

    /**
     * Loads the environment file (.env for example)
     *
     * @param File $file
     * @return void
     */
    public function load(File $file): void
    {
        $dotenv = new Dotenv();
        $dotenv->load($file->getRealPath());
    }

    /**
     * Returns the environment value
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if(!isset($_ENV[$key])) {
            return is_callable($default) ? $default() : $default;
        }

        $value = $_ENV[$key];

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        return $value;
    }

}
