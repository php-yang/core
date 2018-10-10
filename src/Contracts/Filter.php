<?php

namespace Yang\Core\Contracts;

/**
 * Interface Filter
 * @package Yang\Core\Contracts
 */
interface Filter
{
    /**
     * 如果你在filter中直接return，则不会继续调度下一个filter，return的值将作为回溯值开始回溯。
     * If you just return in a filter, will not dispatch next filter and your return bill be an output for backtrace.
     *
     * 如果你yield了一个Filter的对象或类，则其会作为下一个filter被调度（动态插入filter功能）。
     * If you yield a Filter object / class, will dispatch it next(looks like insert a filter next).
     *
     * 要么你yield了一个非null值，则不会继续调度下一个filter，yield的值将作为回溯值开始回溯。
     * If you yield a nonnull value, will not dispatch next filter and the value bill be an output for backtrace.
     *
     * 如果你yield一个null值/或直接yield，则正常继续调度。
     * If you yield a null value or yield directly, will dispatch next filter as normal.
     *
     * 如果你在一个filter中同时使用yield和return一个值，则return会被忽略（PHP Generator机制）。
     * If you use both yield and return value in one filter, the return keyword will be ignored(because of php generator).
     *
     * 你可以在一个filter中同时使用yield和无值return（PHP Generator机制）。
     * You can use both yield and void return in one filter(because of php generator).
     * @param mixed $input
     * @return mixed|void
     */
    public function invoke($input);
}
