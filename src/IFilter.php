<?php

namespace Yang\Core;

interface IFilter
{
    /**
     * @param mixed $input
     */
    public function invoke($input);
}
