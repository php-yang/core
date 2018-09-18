<?php

namespace Yang\Core\Tests;

use Yang\Core\IFilter;

class TestIFilter1 implements IFilter
{
    /**
     * @param Request $request
     */
    public function invoke($request)
    {
        echo $request->total, PHP_EOL;
        $request->total = 1;
        $response = (yield $request);
        echo $response->result, PHP_EOL;
        $response->result = 'filter1';
    }
}