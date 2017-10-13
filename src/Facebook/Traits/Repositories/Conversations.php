<?php

namespace Botomatic\Engine\Facebook\Traits\Repositories;

/**
 * Class Conversations
 * @package Botomatic\Engine\Facebook\Traits\Repositories
 */
trait Conversations
{
    /**
     * @return \Botomatic\Engine\Facebook\Repositories\Conversations
     */
    protected function botomaticFacebookRepositoryConversations() : \Botomatic\Engine\Facebook\Repositories\Conversations
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Facebook\Repositories\Conversations::class, 'botomaticFacebookConversationsRepositories');
    }
}