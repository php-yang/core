<?php

namespace Yang\Core\Contracts;

/**
 * Interface Injectable
 * @package Yang\Core\Contracts
 */
interface Injectable
{
    /**
     * @return void
     */
    public function __inject();

    /**
     * @return bool
     */
    public function __injected();
}
