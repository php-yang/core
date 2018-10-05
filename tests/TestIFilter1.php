<?php

namespace Yang\Core\Tests;

use Yang\Core\IFilter;

class TestIFilter1 implements IFilter
{
    /**
     * @param Request $request
     * @return void|mixed
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
