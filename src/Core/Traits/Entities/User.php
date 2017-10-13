<?php

namespace Botomatic\Engine\Core\Traits\Entities;

/**
 * Class User
 * @package Botomatic\Engine\Core\Traits\Entities
 */
trait User
{
    /**
     * @var \Botomatic\Engine\Core\Entities\User
     */
    protected $user;

    /**
     * @return \Botomatic\Engine\Core\Entities\User
     */
    public function getUser(): \Botomatic\Engine\Core\Entities\User
    {
        return $this->user;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     */
    public function setUser(\Botomatic\Engine\Core\Entities\User $user)
    {
        $this->user = $user;
    }
}