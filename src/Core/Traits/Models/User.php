<?php

namespace Botomatic\Engine\Core\Traits\Models;

/**
 * Class User
 * @package Botomatic\Engine\Core\Traits\Models
 */
trait User
{
    /**
     * @return \Botomatic\Engine\Core\Models\User
     */
    protected function botomaticModelUser() : \Botomatic\Engine\Core\Models\User
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Core\Models\User::class, 'botomaticUserModel');
    }
}