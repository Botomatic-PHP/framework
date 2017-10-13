<?php

namespace Botomatic\Engine\Facebook\Traits\Models;

/**
 * Class Conversation
 * @package Botomatic\Engine\Facebook\Traits\Models
 */
trait Conversation
{
    /**
     * @return \Botomatic\Engine\Facebook\Models\Conversation
     */
    protected function botomaticFacebookModelConversation() : \Botomatic\Engine\Facebook\Models\Conversation
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Facebook\Models\Conversation::class, 'botomaticFacebookConversationModel');
    }
}