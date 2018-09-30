<?php

namespace Yang\Core\Traits;

/**
 * Trait Factory
 * @package Yang\Core\Traits
 */
trait Factory
{
    /**
     * @var array
     */
    private static $sharedInstances = [];

    /**
     * @param mixed ...$params
     * @return static
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }

    /**
     * @param mixed ...$params
     * @return static
     */
    final public static function shared(...$params)
    {
        $class = get_called_class();

        if (!isset(self::$sharedInstances[$class])) {
            self::$sharedInstances[$class] = static::make(...$params);
        }

        return self::$sharedInstances[$class];
    }
}
