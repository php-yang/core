<?php

namespace Yang\Core;

use Generator;
use InvalidArgumentException;
use Yang\Core\Traits\Factory;

class Dispatcher
{
    use Factory;

    const FILTER_CLASS = IFilter::class;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var Generator[]
     */
    protected $generators = [];

    /**
     * @var array
     */
    protected $dispatchedFilters = [];

    public function __destruct()
    {
        unset($this->filters);
        unset($this->generators);
        unset($this->dispatchedFilters);
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
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getDispatchedFilters()
    {
        return $this->dispatchedFilters;
    }

    /**
     * @param mixed $input
     * @param mixed $output
     * @return $this
     */
    public function dispatch($input, $output = null)
    {
        /**
         * @var Generator $generator
         * @var IFilter $filter
         */
        do {
            if (!$this->filters) {
                break;
            }

            $this->generators = [];

            foreach ($this->filters as $filterClass) {
                $this->dispatchedFilters[] = $filterClass;

                $filter = new $filterClass();
                $generator = $filter->invoke($input);
                if (!$generator instanceof Generator) {
                    break;
                }

                $this->generators[] = $generator;

                if (null === $input = $generator->current()) {
                    break;
                }
            }

            if (null !== $output) {
                $this->fallback($output);
            }
        } while (false);

        return $this;
    }

    /**
     * @param mixed $output
     * @return $this
     */
    public function fallback($output)
    {
        do {
            if (!$this->generators) {
                break;
            }

            $generator = end($this->generators);
            do {
                $generator->send($output);
            } while ($generator = prev($this->generators));
        } while (false);

        return $this;
    }
}
