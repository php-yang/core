<?php

namespace Yang\Core;

/**
 * Class Object
 * @package Yang\Core
 */
class Object
{
    /**
     * @param string|object $class
     * @return object
     */
    public static function factory($class)
    {
        return is_object($class) ? $class : new $class;
    }
}
