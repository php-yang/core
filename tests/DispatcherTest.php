<?php

namespace Yang\Core\Tests;

use PHPUnit\Framework\TestCase;
use Yang\Core\Dispatcher;

class DispatcherTest extends TestCase
{
    public function testRun()
    {
        $response = (new Dispatcher)
            ->append(TestFilter1::class)
            ->append([new TestFilter2(), TestFilter3::class])
            ->dispatch(new Request());

        echo '==========================================', PHP_EOL;
        echo var_export($response, true), PHP_EOL;
    }
}
