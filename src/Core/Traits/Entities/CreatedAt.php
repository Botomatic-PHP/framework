<?php

namespace Botomatic\Engine\Core\Traits\Entities;

/**
 * Class CreatedAt
 * @package Botomatic\Engine\Core\Traits\Entities
 */
trait CreatedAt
{
    /**
     * @var \Carbon\Carbon
     */
    protected $created_at;

    /**
     * @author Alexandru Muresan
     *
     * @param $created_at \Carbon\Carbon
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @author Alexandru Muresan
     *
     * @return \Carbon\Carbon
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}