<?php

namespace Yang\Core;

use Generator;

interface IFilter
{
    /**
     * @param mixed $input
     * @return Generator
     */
    public function invoke($input);
}
