<?php

namespace Botomatic\Engine\Core\Traits\Repositories;

/**
 * Class Sessions
 * @package Botomatic\Engine\Core\Traits\Repositories
 */
trait Sessions
{
    /**
     * @return \Botomatic\Engine\Core\Repositories\Sessions
     */
    protected function botomaticRepositorySessions() : \Botomatic\Engine\Core\Repositories\Sessions
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Core\Repositories\Sessions::class, 'botomaticSessionsRepositories');
    }
}