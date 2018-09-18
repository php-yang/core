<?php

namespace Yang\Core\Traits;


trait Singleton
{
    use Factory;

    protected static function make(...$params)
    {
        return new static(...$params);
    }

    protected function __construct()
    {
        // protected
    }

    protected function __clone()
    {
        // protected
    }

    protected function __sleep()
    {
        // protected
    }

    protected function __wakeup()
    {
        // protected
    }
}
