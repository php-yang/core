<?php

namespace Yang\Core;

/**
 * Interface IFilter
 * @package Yang\Core
 */
interface IFilter
{
    /**
     * @param mixed $input
     */
    public function invoke($input);
}
