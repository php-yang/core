<?php

namespace Yang\Core\Tests;

use PHPUnit\Framework\TestCase;
use Yang\Core\Dispatcher;

class DispatcherTest extends TestCase
{
    public function testRun()
    {
        $filter = (new Dispatcher)
            ->appendFilter(TestIFilter1::class)
            ->appendFilter(TestIFilter2::class)
            ->appendFilter(TestIFilter3::class)
            ->dispatch(new Request());

        $response = new Response(); // generate response
        $response->result = 'test';

        $filter->fallback($response);

        echo $response->result, PHP_EOL;
    }
}
