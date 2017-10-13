<?php

namespace Botomatic\Engine\Core\Traits\Entities;

/**
 * Class UpdatedAt
 * @package Botomatic\Engine\Core\Traits\Entities
 */
trait UpdatedAt
{
    /**
     * @var \Carbon\Carbon
     */
    protected $updated_at;

    /**
     * @author Alexandru Muresan
     *
     * @param $updated_at \Carbon\Carbon
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @author Alexandru Muresan
     *
     * @return \Carbon\Carbon
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}