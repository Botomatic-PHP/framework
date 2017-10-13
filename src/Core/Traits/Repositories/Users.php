<?php

namespace Botomatic\Engine\Core\Traits\Repositories;

/**
 * Class Users
 * @package Botomatic\Engine\Core\Traits\Repositories
 */
trait Users
{
    /**
     * @return \Botomatic\Engine\Core\Repositories\Users
     */
    protected function botomaticRepositoryUser() : \Botomatic\Engine\Core\Repositories\Users
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Core\Repositories\Users::class, 'botomaticUserRepositories');
    }
}