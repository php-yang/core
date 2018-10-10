<?php

namespace Yang\Core\Traits;

/**
 * Trait Injection
 * @package Yang\Core\Traits
 */
trait Injection
{
    /**
     * @var bool
     */
    protected $__injected = false;

    public function __inject()
    {
        $this->__injected = true;
    }

    /**
     * @return bool
     */
    public function __injected()
    {
        return $this->__injected;
    }
}
