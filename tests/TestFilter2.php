<?php

namespace Yang\Core\Tests;

use Yang\Core\Contracts\Filter;

class TestFilter2 implements Filter
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function invoke($request)
    {
        echo __CLASS__, ' before', PHP_EOL;

        $response = yield;

        $response->result = __CLASS__;
        echo __CLASS__, ' after', PHP_EOL;
        echo var_export($response, true), PHP_EOL;
    }
}
