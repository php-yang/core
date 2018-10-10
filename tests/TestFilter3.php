<?php

namespace Yang\Core\Tests;

use Yang\Core\Contracts\Filter;

class TestFilter3 implements Filter
{
    /**
     * @param Request $request
     * @return mixed
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
