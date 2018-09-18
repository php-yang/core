<?php

namespace Yang\Core;

use Generator;
use InvalidArgumentException;
use Yang\Core\Traits\Factory;

class FilterDispatcher
{
    use Factory;

    const FILTER_CLASS = FilterInterface::class;

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
     * @param string $filterClass
     * @return $this
     */
    public function appendFilter($filterClass)
    {
        if (!is_subclass_of($filterClass, self::FILTER_CLASS)) {
            throw new InvalidArgumentException('Filter class needs to implement ' . self::FILTER_CLASS);
        }

        $this->filters[] = $filterClass;

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
         * @var FilterInterface $filter
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
