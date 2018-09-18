<?php

namespace Yang\Core\Tests;

use PHPUnit\Framework\TestCase;
use Yang\Core\FilterDispatcher;

class DispatcherTest extends TestCase
{
    public function testRun()
    {
        $filter = (new FilterDispatcher)
            ->appendFilter(TestFilter1::class)
            ->appendFilter(TestFilter2::class)
            ->appendFilter(TestFilter3::class)
            ->dispatch(new Request());

        $response = new Response(); // generate response
        $response->result = 'test';

        $filter->fallback($response);

        echo $response->result, PHP_EOL;
    }
}
