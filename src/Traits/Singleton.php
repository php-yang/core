<?php

namespace Yang\Core\Traits;

/**
 * Trait Singleton
 * @package Yang\Core\Traits
 */
trait Singleton
{
    use Factory;

    /**
     * @inheritdoc
     */
    protected static function make()
    {
        return new static();
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
