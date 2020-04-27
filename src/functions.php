<?php

namespace Runn;

use Runn\Framework\Environment;

/**
 * Returns environment value
 *
 * @param string $key
 * @param null $default
 * @return mixed
 */
function env(string $key, $default = null)
{
    static $env;
    $env = new Environment();
    return $env->get($key, $default);
}
