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

/**
 * Return array of command-line options with ones values
 *
 * @param array $options Options keys
 * @return array Options values
 */
function getopt(array $options): array
{
    global $argv;
    $ret = [];
    $pattern = '~^--(' . implode('|', $options) . ')=\"?(.*)\"?$~';
    if (!empty($argv)) {
        foreach ($argv as $arg) {
            if (preg_match($pattern, $arg, $m)) {
                $ret[$m[1]] = $m[2];
            }
        }
    }
    return $ret;
}
