<?php

namespace Botomatic\Engine\Core\Entities;

/**
 * Class City
 * @package Botomatic\Engine\Core\Entities
 */
class City
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}