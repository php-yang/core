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
     * @return static
     */
    public static function make()
    {
        return new static();
    }

    /**
     * @return static
     */
    final public static function shared()
    {
        $class = get_called_class();

        if (!isset(self::$sharedInstances[$class])) {
            self::$sharedInstances[$class] = static::make();
        }

        return self::$sharedInstances[$class];
    }
}
