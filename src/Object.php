<?php

namespace Yang\Core;

use Yang\Core\Contracts\Injectable;

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
        $object = is_object($class) ? $class : new $class;

        if ($object instanceof Injectable) {
            $object->__injected() || $object->__inject();
        }

        return $object;
    }
}
