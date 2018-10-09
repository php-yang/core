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
     * @var array
     */
    protected $filters = [];

    public function __destruct()
    {
        unset($this->filters);
    }

    /**
     * @api
     * @param string|IFilter|array $filters
     * @return $this
     */
    public function append($filters)
    {
        if (!is_array($filters)) {
            $filters = [$filters];
        }

        foreach ($filters as $filter) {
            if (!is_subclass_of($filter, $this::FILTER_CLASS)) {
                throw new InvalidArgumentException("Filter: {$filter} needs to implement " . $this::FILTER_CLASS);
            }

            $this->filters[] = $filter;
        }

        return $this;
    }

    /**
     * @api
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @api
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

            $generators = [];

            $filter = reset($this->filters);
            while ($filter) {
                $filter = Object::factory($filter);

                $generator = $filter->invoke($input);
                if (!$generator instanceof Generator) {
                    $output = $generator;
                    break;
                }

                $generators[] = $generator;

                $result = $generator->current();
                if (is_subclass_of($result, $this::FILTER_CLASS)) {
                    $filter = $result;
                    continue;
                }

                if (null !== $result) {
                    $output = $result;
                    break;
                }

                $filter = next($this->filters);
            }

            if ($generator = end($generators)) {
                do {
                    $generator->send($output);
                } while ($generator = prev($generators));
            }
        } while (false);

        return $output;
    }
}
