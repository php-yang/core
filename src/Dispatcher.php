<?php

namespace Yang\Core;

use Generator;
use InvalidArgumentException;
use Yang\Core\Traits\Factory;

/**
 * Class Dispatcher
 * @package Yang\Core
 */
class Dispatcher
{
    use Factory;

    const FILTER_CLASS = IFilter::class;

    /**
     * @var string[]
     */
    protected $filters = [];

    /**
     * @var Generator[]
     */
    protected $generators = [];

    /**
     * @var string[]
     */
    protected $dispatchedFilters = [];

    public function __destruct()
    {
        unset($this->filters, $this->generators, $this->dispatchedFilters);
    }

    /**
     * @param string|string[] $filterClasses
     * @return $this
     */
    public function appendFilter($filterClasses)
    {
        if (!is_array($filterClasses)) {
            $filterClasses = [$filterClasses];
        }

        foreach ($filterClasses as $filterClass) {
            if (!is_subclass_of($filterClass, $this::FILTER_CLASS)) {
                throw new InvalidArgumentException("Filter class: {$filterClass} needs to implement " . $this::FILTER_CLASS);
            }

            $this->filters[] = $filterClass;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return string[]
     */
    public function getDispatchedFilters()
    {
        return $this->dispatchedFilters;
    }

    /**
     * @param mixed $input
     * @return mixed
     */
    public function dispatch($input)
    {
        /**
         * @var Generator $generator
         * @var IFilter $filter
         */
        $output = null;

        do {
            if (!$this->filters) {
                break;
            }

            $this->generators = [];

            foreach ($this->filters as $filterClass) {
                if (is_object($filterClass)) {
                    $this->dispatchedFilters[] = get_class($filterClass);
                    $filter = $filterClass;
                } else {
                    $this->dispatchedFilters[] = $filterClass;
                    $filter = new $filterClass();
                }

                $generator = $filter->invoke($input);
                if (!$generator instanceof Generator) {
                    $output = $generator;
                    break;
                }

                $this->generators[] = $generator;

                if (null !== $result = $generator->current()) {
                    $input = $result;
                }
            }

            $this->fallback($output);
        } while (false);

        return $output;
    }

    /**
     * @param mixed $output
     */
    protected function fallback($output)
    {
        if (!$this->generators) {
            return;
        }

        $generator = end($this->generators);
        do {
            $generator->send($output);
        } while ($generator = prev($this->generators));
    }
}
