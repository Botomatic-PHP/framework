<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Support;

/**
 * Class Pagination
 * @package App\Botomatic\Abstracts
 */
abstract class Pagination
{
    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $results_left;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $per_page = 5;

    /**
     * @var array
     */
    protected $default_serialization = ['total', 'offset', 'per_page', 'results_left'];

    /**
     * @var array
     */
    protected $serialization = [];

    /**
     * @return int
     */
    public function total() : int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function results_left() : int
    {
        return $this->results_left;
    }

    /**
     * @return array
     */
    public function next() : array
    {
        $this->offset = $this->offset + $this->per_page;

        if ($this->results_left > $this->per_page)
        {
            $this->results_left = $this->results_left - $this->per_page;
        }
        else
        {
            $this->results_left = 0;
        }

        return $this->query($this->offset);
    }

    /**
     * @return array
     */
    public function get() : array
    {
        return $this->query($this->offset);
    }

    /**
     * @param int $offset
     *
     * @return array
     */
    protected abstract function query(int $offset = 0) : array;


    public function __sleep()
    {
        return array_merge($this->default_serialization, $this->serialization);
    }
}
