<?php

namespace Yang\Core\Tests;

use Yang\Core\IFilter;

class TestIFilter3 implements IFilter
{
    /**
     * @param Request $request
     * @return mixed|null
     */
    public function invoke($request)
    {
        echo __CLASS__, PHP_EOL;

        $response = new Response();

        $response->result = __CLASS__;
        echo var_export($response, true), PHP_EOL;

        return $response;
    }
}
