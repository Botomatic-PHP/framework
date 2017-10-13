<?php

namespace Botomatic\Engine\Facebook\Traits\Repositories;

/**
 * Class Scopes
 * @package Botomatic\Engine\Facebook\Traits\Repositories
 */
trait Scopes
{
    /**
     * @return \Botomatic\Engine\Facebook\Repositories\Scopes
     */
    protected function botomaticFacebookRepositoryScopes() : \Botomatic\Engine\Facebook\Repositories\Scopes
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Facebook\Repositories\Scopes::class, 'botomaticFacebookScopesRepositories');
    }
}