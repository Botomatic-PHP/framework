<?php

namespace Botomatic\Engine\Core\Traits\Entities;

/**
 * Class Id
 * @package Botomatic\Engine\Core\Traits\Entities
 */
trait Id
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Checks if the entity is empty
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}