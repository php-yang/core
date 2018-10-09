<?php

namespace Yang\Core\Tests;

use Yang\Core\IFilter;

class TestFilter1 implements IFilter
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function invoke($request)
    {
        echo __CLASS__, ' before', PHP_EOL;

        if (rand(1000, 9999) % 2) {
            $response = yield TestFilter4::class;
        } else {
            $response = yield new Response();
        }

        $response->result = __CLASS__;
        echo __CLASS__, ' after', PHP_EOL;
        echo var_export($response, true), PHP_EOL;
    }
}
