<?php

namespace Yang\Core;

use Generator;

interface FilterInterface
{
    /**
     * @param mixed $input
     * @return Generator
     */
    public function invoke($input);
}
