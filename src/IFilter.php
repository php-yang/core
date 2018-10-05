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
     * @return void|mixed
     */
    public function invoke($input);
}
