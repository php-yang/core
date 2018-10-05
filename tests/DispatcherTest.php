<?php

namespace Yang\Core\Tests;

use PHPUnit\Framework\TestCase;
use Yang\Core\Dispatcher;

class DispatcherTest extends TestCase
{
    public function testRun()
    {
        $response = (new Dispatcher)
            ->appendFilter(TestIFilter1::class)
            ->appendFilter(TestIFilter2::class)
            ->appendFilter(TestIFilter3::class)
            ->dispatch(new Request());

        echo '==========================================', PHP_EOL;
        echo var_export($response, true), PHP_EOL;
    }
}
