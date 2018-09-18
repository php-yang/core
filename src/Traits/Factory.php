<?php

namespace Yang\Core\Traits;


trait Factory
{
    private static $sharedInstances = [];

    public static function make(...$params)
    {
        return new static(...$params);
    }

    final public static function shared(...$params)
    {
        $class = get_called_class();

        if (!isset(self::$sharedInstances[$class])) {
            self::$sharedInstances[$class] = static::make(...$params);
        }

        return self::$sharedInstances[$class];
    }
}
